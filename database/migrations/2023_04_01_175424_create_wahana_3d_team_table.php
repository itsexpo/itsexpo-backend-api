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
        Schema::create('wahana_3d_team', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pembayaran_id')->nullable();
            $table->uuid('user_id')->index();
            $table->string('team_name', 512);
            $table->string('team_code', 512);
            $table->text('deskripsi_karya');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

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
        Schema::dropIfExists('wahana_3d_team');
    }
};
