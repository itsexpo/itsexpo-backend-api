<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jurnalistik_team', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pembayaran_id')->nullable();
            $table->string('team_name', 512);
            $table->string('team_code', 512);
            $table->string('lomba_category', 512);
            $table->integer('jumlah_anggota');
            $table->boolean('team_status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('pembayaran_id')->references('id')->on('pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnalistik_team');
    }
};
