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
            $table->string('departemen_id')->index();
            $table->string('member_type', 512);
            $table->string('name', 512);
            $table->string('nrp', 512);
            $table->string('kontak', 512);
            $table->string('ktm_url', 512);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('wahana_3d_team_id')->references('id')->on('wahana_3d_team')->onDelete("set null");
            $table->foreign('departemen_id')->references('id')->on('departemen');
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
