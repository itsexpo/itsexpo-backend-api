<?php

use App\Infrastrucutre\Service\GetIP;
use App\Infrastrucutre\Service\JwtManager;
use App\Core\Domain\Service\GetIPInterface;
use App\Core\Domain\Service\JwtManagerInterface;
use App\Infrastrucutre\Repository\SqlDesaRepository;
use App\Infrastrucutre\Repository\SqlRoleRepository;
use App\Infrastrucutre\Repository\SqlUserRepository;
use App\Core\Domain\Repository\DesaRepositoryInterface;
use App\Core\Domain\Repository\RoleRepositoryInterface;
use App\Core\Domain\Repository\UserRepositoryInterface;
use App\Infrastrucutre\Repository\SqlFakultasRepository;
use App\Infrastrucutre\Repository\SqlProvinsiRepository;
use App\Infrastrucutre\Repository\SqlKabupatenRepository;
use App\Infrastrucutre\Repository\SqlKecamatanRepository;
use App\Infrastrucutre\Repository\SqlDepartemenRepository;
use App\Infrastrucutre\Repository\SqlPermissionRepository;
use App\Core\Domain\Repository\FakultasRepositoryInterface;
use App\Core\Domain\Repository\ProvinsiRepositoryInterface;
use App\Core\Domain\Repository\KabupatenRepositoryInterface;
use App\Core\Domain\Repository\KecamatanRepositoryInterface;
use App\Infrastrucutre\Repository\SqlUrlShortenerRepository;
use App\Core\Domain\Repository\DepartemenRepositoryInterface;
use App\Core\Domain\Repository\PermissionRepositoryInterface;
use App\Infrastrucutre\Repository\SqlPasswordResetRepository;
use App\Core\Domain\Repository\UrlShortenerRepositoryInterface;
use App\Core\Domain\Repository\PasswordResetRepositoryInterface;
use App\Infrastrucutre\Repository\SqlRoleHasPermissionRepository;
use App\Infrastrucutre\Repository\SqlAccountVerificationRepository;
use App\Core\Domain\Repository\RoleHasPermissionRepositoryInterface;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikMemberRepositoryInterface;
use App\Core\Domain\Repository\JurnalistikTeamRepositoryInterface;
use App\Core\Domain\Repository\ListBankRepositoryInterface;
use App\Core\Domain\Repository\ListEventRepositoryInterface;
use App\Core\Domain\Repository\PengumumanRepositoryInterface;
use App\Infrastrucutre\Repository\SqlJurnalistikMemberRepository;
use App\Infrastrucutre\Repository\SqlJurnalistikTeamRepository;
use App\Core\Domain\Repository\UserHasListEventRepositoryInterface;
use App\Infrastrucutre\Repository\SqlListEventRepository;
use App\Infrastrucutre\Repository\SqlPengumumanRepository;
use App\Core\Domain\Repository\PembayaranRepositoryInterface;
use App\Infrastrucutre\Repository\SqlPembayaranRepository;
use App\Core\Domain\Repository\StatusPembayaranRepositoryInterface;
use App\Infrastrucutre\Repository\SqlListBankRepository;
use App\Infrastrucutre\Repository\SqlStatusPembayaranRepository;
use App\Infrastrucutre\Repository\SqlUserHasListEventRepository;
use App\core\domain\Repository\RobotInActionMemberRepositoryInterface;
use App\core\domain\Repository\RobotInActionTeamRepositoryInterface;
use App\Infrastrucutre\Repository\SqlRobotInActionMemberRepository;
use App\Infrastrucutre\Repository\SqlRobotInActionTeamRepository;

/** @var Application $app */

$app->singleton(UserRepositoryInterface::class, SqlUserRepository::class);
$app->singleton(FakultasRepositoryInterface::class, SqlFakultasRepository::class);
$app->singleton(DepartemenRepositoryInterface::class, SqlDepartemenRepository::class);
$app->singleton(ProvinsiRepositoryInterface::class, SqlProvinsiRepository::class);
$app->singleton(KabupatenRepositoryInterface::class, SqlKabupatenRepository::class);
$app->singleton(KecamatanRepositoryInterface::class, SqlKecamatanRepository::class);
$app->singleton(DesaRepositoryInterface::class, SqlDesaRepository::class);
$app->singleton(RoleRepositoryInterface::class, SqlRoleRepository::class);
$app->singleton(PermissionRepositoryInterface::class, SqlPermissionRepository::class);
$app->singleton(RoleHasPermissionRepositoryInterface::class, SqlRoleHasPermissionRepository::class);
$app->singleton(AccountVerificationRepositoryInterface::class, SqlAccountVerificationRepository::class);
$app->singleton(JwtManagerInterface::class, JwtManager::class);
$app->singleton(GetIPInterface::class, GetIP::class);
$app->singleton(PasswordResetRepositoryInterface::class, SqlPasswordResetRepository::class);
$app->singleton(UrlShortenerRepositoryInterface::class, SqlUrlShortenerRepository::class);
$app->singleton(PengumumanRepositoryInterface::class, SqlPengumumanRepository::class);
$app->singleton(JurnalistikTeamRepositoryInterface::class, SqlJurnalistikTeamRepository::class);
$app->singleton(JurnalistikMemberRepositoryInterface::class, SqlJurnalistikMemberRepository::class);
$app->singleton(PembayaranRepositoryInterface::class, SqlPembayaranRepository::class);
$app->singleton(StatusPembayaranRepositoryInterface::class, SqlStatusPembayaranRepository::class);
$app->singleton(ListEventRepositoryInterface::class, SqlListEventRepository::class);
$app->singleton(UserHasListEventRepositoryInterface::class, SqlUserHasListEventRepository::class);
$app->singleton(ListBankRepositoryInterface::class, SqlListBankRepository::class);
$app->singleton(RobotInActionTeamRepositoryInterface::class, SqlRobotInActionTeamRepository::class);
$app->singleton(RobotInActionMemberRepositoryInterface::class, SqlRobotInActionMemberRepository::class);
