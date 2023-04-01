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
        Schema::create('wahana_3d_member', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wahana_3d_team_id')->nullable();
            $table->uuid('user_id')->index();
            $table->string('name', 512);
            $table->string('no_telp', 512);
            $table->string('member_type', 512);
            $table->string('asal_sekolah', 512);
            $table->string('id_card_url', 512);
            $table->string('follow_sosmed_url', 512);
            $table->string('share_poster_url', 512);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('wahana_3d_team_id')->references('id')->on('wahana_3d_team')->onDelete("set null");
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
        Schema::dropIfExists('wahana_3d_member');
    }
};
