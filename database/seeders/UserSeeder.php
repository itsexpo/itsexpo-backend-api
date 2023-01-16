<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Core\Domain\Models\User\UserId;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/user.json'));
        $users = json_decode($json, true);

        $payload = [];
        foreach ($users as $user) {
            $payload[] = [
                'id' => UserId::generate()->toString(),
                'role_id' => $user['role_id'],
                'email' => $user['email'],
                'no_telp' => $user['no_telp'],
                'is_valid' => $user['is_valid'],
                'name' => $user['name'],
                'password' => Hash::make($user['password']),
            ];
        }
        DB::table('user')->insert($payload);
    }
}
