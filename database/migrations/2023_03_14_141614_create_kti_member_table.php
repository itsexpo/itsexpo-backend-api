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
        Schema::create('kti_member', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('kti_team_id');
            $table->string('name', 512);
            $table->string('no_telp', 512);
            $table->string('member_type', 512);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('kti_team_id')->references('id')->on('kti_team');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kti_member');
    }
};
