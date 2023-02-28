<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = file_get_contents(database_path('seeders/json/status_pembayaran.json'));
        $status_pembayarans = json_decode($json, true);

        $payload = [];
        foreach ($status_pembayarans as $status_pembayaran) {
            $payload[] = [
                'id' => $status_pembayaran['id'],
                'status' => $status_pembayaran['status'],
            ];
        }
        DB::table('status_pembayaran')->insert($payload);
    }
}