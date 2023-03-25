<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/role.json'));
        $roles = json_decode($json, true);

        $payload = [];
        foreach ($roles as $role) {
            $payload[] = [
                'id' => $role['id'],
                'name' => $role['name']
            ];
        }
        DB::table('role')->insert($payload);
    }
}
