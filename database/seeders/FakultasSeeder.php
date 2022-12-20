<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/fakultas.json'));
        $fakultass = json_decode($json, true);

        $payload = [];
        foreach ($fakultass as $fakultas) {
            $payload[] = [
                'id' => $fakultas['id'],
                'name' => $fakultas['name'],
                'singkatan' => $fakultas['singkatan']
            ];
        }
        DB::table('fakultas')->insert($payload);
    }
}
