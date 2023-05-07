<?php

namespace App\Core\Application\Service\RegisterJurnalistikTeam;

use Illuminate\Support\Carbon;
use App\Exceptions\UserException;
use App\Core\Domain\Models\UserAccount;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\Pembayaran\Pembayaran;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikTeam;
use App\Core\Domain\Models\Jurnalistik\JurnalistikMemberType;
use App\Core\Domain\Models\UserHasListEvent\UserHasListEvent;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Member\JurnalistikMember;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikJenisKegiatan;
use App\Core\Domain\Models\Jurnalistik\Team\JurnalistikLombaCategory;

class RegisterJurnalistikTeamService
{
    private JurnalistikTeamRepositoryInterface $jurnalistik_team_repository;
    private JurnalistikMemberRepositoryInterface $jurnalistik_member_repository;
    private UserHasListEventRepositoryInterface $user_has_list_event_repository;
    private UserRepositoryInterface $user_repository;
    private RoleRepositoryInterface $role_repository;
    private PembayaranRepositoryInterface $pembayaran_repository;

    /**
     * @param JurnalistikTeamRepositoryInterface $jurnalistik_team_repository
     * @param JurnalistikMemberRepositoryInterface $jurnalistik_member_repository
     * @param UserHasListEventRepositoryInterface $user_has_list_event_repository
     * @param UserRepositoryInterface $user_repository
     * @param RoleRepositoryInterface $role_repository
     */
    public function __construct(
        JurnalistikTeamRepositoryInterface $jurnalistik_team_repository,
        JurnalistikMemberRepositoryInterface $jurnalistik_member_repository,
        UserHasListEventRepositoryInterface $user_has_list_event_repository,
        UserRepositoryInterface $user_repository,
        RoleRepositoryInterface $role_repository,
        PembayaranRepositoryInterface $pembayaran_repository
    ) {
        $this->jurnalistik_team_repository = $jurnalistik_team_repository;
        $this->jurnalistik_member_repository = $jurnalistik_member_repository;
        $this->user_has_list_event_repository = $user_has_list_event_repository;
        $this->user_repository = $user_repository;
        $this->role_repository = $role_repository;
        $this->pembayaran_repository = $pembayaran_repository;
    }

    public function execute(RegisterJurnalistikTeamRequest $request, UserAccount $account)
    {
        UserException::throw("Pendaftaran event jurnalistik sudah ditutup", 1001, 404);
        // Cek User Terdaftar
        $registeredUser = $this->jurnalistik_member_repository->findByUserId($account->getUserId());
        $user = $this->user_repository->find($account->getUserId());
        if ($registeredUser) {
            UserException::throw("User Sudah Mendaftar di Event Jurnalistik", 1001, 404);
        }

        $role = $this->role_repository->find($user->getRoleId());

        $lomba_category = null;
        $jenis_kegiatan = JurnalistikJenisKegiatan::from($request->getJenisKegiatan());
        $lomba_category = JurnalistikLombaCategory::from($request->getLombaCategory());

        if ($role->getName() == 'SMA/Sederajat') {
            if ($lomba_category != JurnalistikLombaCategory::BLOGGER) {
                UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Kategori Lomba yang Dipilih Team", 6003);
            }
        } elseif ($role->getName() == 'Mahasiswa' || $role->getName() == 'Umum') {
            if ($lomba_category != JurnalistikLombaCategory::TELEVISION) {
                UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Kategori Lomba yang Dipilih Team", 6003);
            }
        } else {
            UserException::throw("Role Anda Tidak Diperbolehkan Mengikuti Lomba Ini", 6002);
        }


        // PEMBATASAN QUOTA
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

        // Generate Team Code
        if ($role->getName() == 'SMA/Sederajat') {
            $team_code = 'JR-VG-CITS-' . str_pad($this->jurnalistik_team_repository->countAllTeams(JurnalistikLombaCategory::BLOGGER) + 1, 3, "0", STR_PAD_LEFT);
        } elseif ($role->getName() == 'Mahasiswa' || $role->getName() == 'Umum') {
            $team_code = 'JR-TV-CITS-' . str_pad($this->jurnalistik_team_repository->countAllTeams(JurnalistikLombaCategory::TELEVISION) + 1, 3, "0", STR_PAD_LEFT);
        }

        $current_time = Carbon::now()->addDay();

        $pembayaran = Pembayaran::create(
            null,
            11,
            5,
            null,
            null,
            null,
            $current_time
        );

        $this->pembayaran_repository->persist($pembayaran);

        $team = JurnalistikTeam::create(
            $pembayaran->getId(),
            $request->getTeamName(),
            $team_code,
            false,
            1,
            $lomba_category,
            $jenis_kegiatan
        );

        $this->jurnalistik_team_repository->persist($team);

        // Cek File Exception
        $idCardUrl = ImageUpload::create(
            $request->getIdCard(),
            'jurnalistik/id_card',
            $account->getUserId()->toString(),
            "ID Card"
        )
            ->upload();

        $followUrl = ImageUpload::create(
            $request->getFollowSosmedUrl(),
            'jurnalistik/follow_sosmed',
            $account->getUserId()->toString(),
            "Follow Sosmed"
        )
            ->upload();

        $shareUrl = ImageUpload::create(
            $request->getSharePosterUrl(),
            'jurnalistik/share_poster',
            $account->getUserId()->toString(),
            "Share Poster"
        )
            ->upload();

        // Ceate Member
        $member = JurnalistikMember::create(
            $team->getId(),
            $account->getUserId(),
            $request->getKabupatenId(),
            $request->getProvinsiId(),
            $request->getName(),
            JurnalistikMemberType::KETUA,
            $request->getAsalInstansi(),
            $request->getIdLine(),
            $idCardUrl,
            $followUrl,
            $shareUrl
        );
        $this->jurnalistik_member_repository->persist($member);
        $user_has_list_event = UserHasListEvent::create(
            11,
            $member->getUserId(),
        );
        $this->user_has_list_event_repository->persist($user_has_list_event);
    }
}
