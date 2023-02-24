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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('list_event_id')->index();
            $table->integer('list_bank_id')->index();
            $table->integer('status_pembayaran_id')->index();
            $table->string('bukti_pembayaran_url', 512);
            $table->integer('harga');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('list_event_id')->references('id')->on('list_event');
            $table->foreign('list_bank_id')->references('id')->on('list_bank');
            $table->foreign('status_pembayaran_id')->references('id')->on('status_pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};
