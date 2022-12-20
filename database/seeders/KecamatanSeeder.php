<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
