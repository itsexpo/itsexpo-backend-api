<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kecamatan')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/kecamatan.json'));
        $kecamatans = json_decode($json, true);

        $payload = [];
        foreach ($kecamatans as $kecamatan) {
            $payload[] = [
                'id' => $kecamatan['id'],
                'kabupaten_id' => $kecamatan['kabupaten_id'],
                'name' => $kecamatan['name']
            ];
        }
        DB::table('kecamatan')->insert($payload);
    }
}
