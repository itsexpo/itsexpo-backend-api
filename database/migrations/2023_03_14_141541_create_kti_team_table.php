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
        Schema::create('kti_team', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pembayaran_id')->nullable();
            $table->uuid('user_id')->index();
            $table->string('team_name', 512);
            $table->string('asal_instansi', 512);
            $table->string('follow_sosmed', 512);
            $table->string('bukti_repost', 512);
            $table->string('twibbon', 512);
            $table->string('abstrak', 512);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->usrCurrentOnUpdate();

            $table->foreign('pembayaran_id')->references('id')->on('pembayaran');
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kti_team');
    }
};
