<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/list_event.json'));
        $list_events = json_decode($json, true);

        $payload = [];
        foreach ($list_events as $list_event) {
            $payload[] = [
                'id' => $list_event['id'],
                'name' => $list_event['name'],
                'kuota' => $list_event['kuota'],
                'start_date' => $list_event['start_date'],
                'close_date' => $list_event['close_date'],
            ];
        }
        DB::table('list_event')->insert($payload);
    }
}
