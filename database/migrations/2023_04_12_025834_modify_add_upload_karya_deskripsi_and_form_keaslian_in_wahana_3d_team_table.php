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
        Schema::table('wahana_3d_team', function (Blueprint $table) {
            $table->string('upload_karya_url')->nullable();
            $table->string('deskripsi_url')->nullable();
            $table->string('form_keaslian_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wahana_3d_team', function (Blueprint $table) {
            $table->dropColumn('upload_karya_url');
            $table->dropColumn('deskripsi_url');
            $table->dropColumn('form_keaslian_url');
        });
    }
};
