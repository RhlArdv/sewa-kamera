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
        Schema::create('tb_transaction', function (Blueprint $table) {
            $table->id('id_transaction');
            $table->unsignedBigInteger('user_id');
            $table->string('code')->unique();
            $table->bigInteger('total_price')->default(0);
            $table->bigInteger('uang_panjar')->default(0);
            $table->string('city');
            $table->unsignedBigInteger('bayar_id')->nullable();
            $table->string('transaksi_status')->default('pending'); // pending, dp_paid, completed, cancelled
            $table->text('keterangan')->nullable();
            $table->string('receiver');
            $table->date('tanggal_sewa');
            $table->string('ktp_path')->nullable();
            $table->string('ktp_status')->default('pending'); // pending, approved, rejected
            $table->string('midtrans_snap_token')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('bayar_id')
                  ->references('id_bayar')
                  ->on('tb_bayar')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaction');
    }
};
