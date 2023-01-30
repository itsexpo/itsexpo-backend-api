<?php

namespace App\Infrastrucutre\Repository;

use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\Role\Role;
use App\Core\Domain\Repository\RoleRepositoryInterface;

class SqlRoleRepository implements RoleRepositoryInterface
{
    public function persist(Role $role): void
    {
        DB::table('role')->upsert([
            'id' => $role->getId(),
            'name' => $role->getName(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(string $id): ?Role
    {
        $row = DB::table('role')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findLargestId(): ?string
    {
        $row = DB::table('role')->max('id');

        if (!$row) {
            return null;
        }

        return $row;
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): Role
    {
        return new Role(
            $row->id,
            $row->name,
        );
    }

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('role')
            ->paginate($per_page, ['*'], 'role_page', $page);
        $roles = [];

        foreach ($rows as $row) {
            $roles[] = $this->constructFromRow($row);
        }
        return [
            "data" => $roles,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function delete(string $id): void
    {
        DB::table('role')->where('id', $id)->delete();
    }
}
