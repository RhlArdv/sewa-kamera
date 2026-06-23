<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_pelunasan', function (Blueprint $table) {
            $table->id('id_pelunasan');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transaction_id');
            $table->string('status_transaction'); // DP, Lunas
            $table->bigInteger('total_semua');
            $table->bigInteger('uang_dp');
            $table->bigInteger('sisa_bayar');
            $table->string('bukti_pelunasan')->nullable();
            $table->string('midtrans_snap_token_pelunasan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('transaction_id')
                  ->references('id_transaction')
                  ->on('tb_transaction')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pelunasan');
    }
};
