<?php

namespace App\Core\Application\Service\UpdatePembayaran;

use Carbon\Carbon;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Models\Pembayaran\PembayaranId;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikJenisKegiatan;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikLombaCategory;
use App\Core\Domain\Models\RobotInAction\Team\RobotInActionCompetitionStatus;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;

class UpdatePembayaranService
{
    private PembayaranRepositoryInterface $pembayaran_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;
    private RobotInActionTeamRepositoryInterface $robot_in_action_team_repository;
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;

    public function __construct(
        PembayaranRepositoryInterface $pembayaran_repository,
        UserRepositoryInterface $user_repository,
        RoleRepositoryInterface $role_repository,
        RobotInActionTeamRepositoryInterface $robot_in_action_team_repository,
        JurnalistikTeamRepositoryInterface $jurnalistik_team_repository,
        JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
    ) {
        $this->pembayaran_repository = $pembayaran_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
        $this->robot_in_action_team_repository = $robot_in_action_team_repository;
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
    }

    public function execute(UpdatePembayaranRequest $request, UserAccount $account)
    {
        $pembayaran = $this->pembayaran_repository->find(new PembayaranId($request->getPaymentId()));
        $user = $this->user_repository->find($account->getUserId());
        $role = $this->role_repository->find($user->getRoleId());

        if (!$pembayaran) {
            UserException::throw("Pembayaran tidak bisa ditemukan", 6099);
        }

        if ($pembayaran->getStatusPembayaranId() !== 1) {
            UserException::throw("Gagal mengubah waktu pembayaran", 6099);
        }

        //cek kuota
        $event_id = $pembayaran->getListEventId();
        if ($event_id == 13) {
            $competition_status = null;
            if ($role->getName() == 'SMA/Sederajat') {
                $competition_status = RobotInActionCompetitionStatus::from('BENTENGAN');
            } elseif ($role->getName() == 'SMP/Sederajat') {
                $competition_status = RobotInActionCompetitionStatus::from('LINE_TRACER');
            } else {
                UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Lomba Ini", 6095);
            }
            $LINE_TRACER = 500;
            $BENTENGAN = 500;
            if ($competition_status == RobotInActionCompetitionStatus::LINE_TRACER) {
                $count = $this->robot_in_action_team_repository->countByCompetitionStatus($competition_status);
                if ($count >= $LINE_TRACER) {
                    UserException::throw("Kompetisi LINE TRACER Sudah Penuh", 6096);
                }
            } else {
                $count = $this->robot_in_action_team_repository->countByCompetitionStatus($competition_status);
                if ($count >= $BENTENGAN) {
                    UserException::throw("Kompetisi BENTENGAN Sudah Penuh", 6097);
                }
            }
        } elseif ($event_id == 11) {
            $jurnalistik_member = $this->jurnalistik_member_repository->findByUserId($user->getId());
            $jurnalistik_team_id = $jurnalistik_member->getJurnalistikTeamId();
            $jurnalistik_team = $this->jurnalistik_team_repository->find($jurnalistik_team_id);
            $jenis_kegiatan = $jurnalistik_team->getJenisKegiatan();
            $KHUSUS = 10;
            $UMUM = 20;
            if ($jenis_kegiatan == JurnalistikJenisKegiatan::KHUSUS) {
                //Mendapatkan total dari team yang mendaftar Jenis KHUSUS
                $count = $this->jurnalistik_team_repository->countTeamWithJenis($jenis_kegiatan);
                if ($count >= $KHUSUS) {
                    UserException::throw("Jenis Kegiatan Khusus Sudah Penuh", 6002);
                }
            } else {
                //karna menggunakan variable maka pencarian bergantung pada variable tersebut
                //ini hanya work jika Kategori BLOGGER dan TELEVISION memiliki batas yang sama
                if ($user->getRoleId() == 4) {
                    $count = $this->jurnalistik_team_repository->countTeamWithJenisAndCategory(JurnalistikJenisKegiatan::KHUSUS, JurnalistikLombaCategory::BLOGGER);
                    if ($count >= $UMUM) {
                        UserException::throw("Kategori Lomba Blogger Sudah Penuh", 6002);
                    }
                } elseif ($user->getRoleId() == 5) {
                    $count = $this->jurnalistik_team_repository->countTeamWithJenisAndCategory(JurnalistikJenisKegiatan::KHUSUS, JurnalistikLombaCategory::TELEVISION);
                    if ($count >= $UMUM) {
                        UserException::throw("Kategori Lomba Television Sudah Penuh", 6002);
                    }
                }
            }
        }

        $newPembayaran = new Pembayaran(
            new PembayaranId($request->getPaymentId()),
            $pembayaran->getListBankId(),
            $pembayaran->getListEventId(),
            5,
            $pembayaran->getAtasNama(),
            $pembayaran->getBuktiPembayaranUrl(),
            $pembayaran->getHarga(),
            Carbon::now()->addHours(5)
        );

        $this->pembayaran_repository->persist($newPembayaran);
    }
}
