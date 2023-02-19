<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/list_bank.json'));
        $list_banks = json_decode($json, true);

        $payload = [];
        foreach ($list_banks as $list_bank) {
            $payload[] = [
                'id' => $list_bank['id'],
                'name' => $list_bank['name'],
            ];
        }
        DB::table('list_bank')->insert($payload);
    }
}
