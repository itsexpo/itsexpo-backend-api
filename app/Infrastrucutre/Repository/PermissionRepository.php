<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Permission\Permission;
use App\Core\Domain\Models\Permission\PermissionId;
use App\Core\Domain\Repository\PermissionRepositoryInterface;

class SqlPermissionRepository implements PermissionRepositoryInterface
{
    public function persist(Permission $permission): void
    {
        DB::table('permission')->upsert([
            'id' => $permission->getId()->toString(),
            'routes' => $permission->getRoutes(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(PermissionId $id): ?Permission
    {
        $row = DB::table('permission')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): Permission
    {
        return new Permission(
            new PermissionId($row->id),
            $row->routes,
        );
    }
}
