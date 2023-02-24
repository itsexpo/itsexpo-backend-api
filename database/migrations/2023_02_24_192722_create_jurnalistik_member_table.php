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
        Schema::create('jurnalistik_member', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jurnalistik_team_id')->nullable();
            $table->uuid('user_id')->index();
            $table->string('provinsi_id')->index();
            $table->string('kabupaten_id')->index();
            $table->string('name', 512);
            $table->string('asal_instansi', 512);
            $table->string('id_line', 512);
            $table->string('id_card_url', 512);
            $table->string('follow_sosmed_url', 512);
            $table->string('share_poster_url', 512);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('jurnalistik_team_id')->references('id')->on('jurnalistik_team');
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('provinsi_id')->references('id')->on('provinsi');
            $table->foreign('kabupaten_id')->references('id')->on('kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jurnalistik_member');
    }
};
