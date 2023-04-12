<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // FakultasSeeder::class,
            // DepartemenSeeder::class,
            // ProvinsiSeeder::class,
            // KabupatenSeeder::class,
            // KecamatanSeeder::class,
            // DesaSeeder::class,
            // RoleSeeder::class,
            // RoleHasPermissionSeeder::class,
            // UserSeeder::class,
            // ListEventSeeder::class,
            // StatusPembayaranSeeder::class,
            PermissionSeeder::class,
            ListBankSeeder::class,
        ]);
    }
}
