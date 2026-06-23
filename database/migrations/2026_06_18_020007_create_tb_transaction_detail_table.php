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
        Schema::create('tb_transaction_detail', function (Blueprint $table) {
            $table->id('id_transaksi_detail');
            $table->unsignedBigInteger('transaksi_id');
            $table->unsignedBigInteger('produk_id');
            $table->bigInteger('price');
            $table->integer('banyak');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->integer('duration_hours');
            $table->bigInteger('subtotal');
            $table->string('code_produk')->nullable();
            $table->timestamps();

            $table->foreign('transaksi_id')
                  ->references('id_transaction')
                  ->on('tb_transaction')
                  ->onDelete('cascade');

            $table->foreign('produk_id')
                  ->references('id_produk')
                  ->on('tb_product')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaction_detail');
    }
};
