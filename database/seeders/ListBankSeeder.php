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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('list_bank')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $json = file_get_contents(database_path('seeders/json/list_bank.json'));
        $list_banks = json_decode($json, true);

        $payload = [];
        $i = 1;
        foreach ($list_banks as $list_bank) {
            $payload[] = [
                'id' => $i,
                'name' => $list_bank['name'],
            ];
            $i++;
        }
        DB::table('list_bank')->insert($payload);
    }
}
