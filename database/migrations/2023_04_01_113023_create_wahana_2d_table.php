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
        Schema::create('wahana_2d', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index();
            $table->uuid('pembayaran_id')->nullable();
            $table->string('departemen_id')->index();
            $table->string('name', 512);
            $table->string('nrp', 512);
            $table->string('kontak', 512);
            $table->boolean('status');
            $table->string('ktm_url', 512);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('pembayaran_id')->references('id')->on('pembayaran');
            $table->foreign('departemen_id')->references('id')->on('departemen');
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
        Schema::dropIfExists('robot_in_action_team');
    }
};
