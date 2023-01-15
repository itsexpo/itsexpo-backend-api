<?php

use App\Infrastrucutre\Service\JwtManager;
use App\Core\Domain\Service\JwtManagerInterface;
use Illuminate\Contracts\Foundation\Application;
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
use App\Core\Domain\Repository\FakultasRepositoryInterface;
use App\Core\Domain\Repository\ProvinsiRepositoryInterface;
use App\Core\Domain\Repository\KabupatenRepositoryInterface;
use App\Core\Domain\Repository\KecamatanRepositoryInterface;
use App\Core\Domain\Repository\DepartemenRepositoryInterface;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

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
$app->singleton(JwtManagerInterface::class, JwtManager::class);
