<?php

namespace App\Infrastrucutre\Repository;

use App\Core\Domain\Models\Email;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Repository\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlUserRepository implements UserRepositoryInterface
{
    public function persist(User $user): void
    {
        DB::table('user')->upsert([
            'id' => $user->getId()->toString(),
            'role_id' => $user->getRoleId(),
            'email' => $user->getEmail()->toString(),
            'no_telp' => $user->getNoTelp(),
            'name' => $user->getName(),
            'is_valid' => $user->getIsValid(),
            'password' => $user->getHashedPassword()
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(UserId $id): ?User
    {
        $row = DB::table('user')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    public function findByEmail(Email $email): ?User
    {
        $row = DB::table('user')->where('email', $email->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRow($row);
    }

    /**
     * @throws Exception
     */
    private function constructFromRow($row): User
    {
        return new User(
            new UserId($row->id),
            $row->role_id,
            new Email($row->email),
            $row->no_telp,
            $row->name,
            $row->is_valid,
            $row->password
        );
    }

    public function getWithPagination(int $page, int $per_page): array
    {
        $rows = DB::table('user')
            ->paginate($per_page, ['*'], 'npc_team_page', $page);
        $users = [];

        foreach ($rows as $row) {
            $users[] = $this->constructFromRow($row);
        }
        return [
            "data" => $users, 
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function delete(UserId $id): void
    {
        DB::table('user')->where('id', $id->toString())->delete();
    }
}
