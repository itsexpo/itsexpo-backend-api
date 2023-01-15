<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Role\Role;
use App\Core\Domain\Models\Role\RoleId;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class SqlRoleRepository implements RoleRepositoryInterface
{
    public function persist(Role $role): void
    {
        DB::table('role')->upsert([
            'id' => $role->getId()->toString(),
            'user_id' => $role->getUserId()->toString(),
            'name' => $role->getName(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(RoleId $id): ?Role
    {
        $row = DB::table('role')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByUserId(UserId $user_id): ?Role
    {
        $row = DB::table('role')->where('user_id', $user_id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): Role
    {
        return new Role(
            new RoleId($row->id),
            new UserId($row->user_id),
            $row->name,
        );
    }
}
