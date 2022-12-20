<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/departemen.json'));
        $departemens = json_decode($json, true);

        $payload = [];
        foreach ($departemens as $departemen) {
            $payload[] = [
                'id' => $departemen['id'],
                'fakultas_id' => $departemen['fakultas_id'],
                'name' => $departemen['name']
            ];
        }
        DB::table('departemen')->insert($payload);
    }
}
