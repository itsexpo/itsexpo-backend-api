<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permission')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/role_has_permission.json'));
        $role_has_permissions = json_decode($json, true);

        $payload = [];
        foreach ($role_has_permissions as $role_has_permission) {
            $payload[] = [
                'id' => $role_has_permission['id'],
                'role_id' => $role_has_permission['role_id'],
                'permission_id' => $role_has_permission['permission_id']
            ];
        }
        DB::table('role_has_permission')->insert($payload);
    }
}
