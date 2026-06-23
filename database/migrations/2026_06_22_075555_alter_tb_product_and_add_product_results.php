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
        Schema::table('tb_product', function (Blueprint $table) {
            // Drop old price
            $table->dropColumn('price');
            // Add new prices json
            $table->json('prices')->nullable()->after('unit');
        });

        Schema::create('product_results', function (Blueprint $table) {
            $table->id('id_result');
            $table->unsignedBigInteger('produk_id');
            $table->string('foto');
            $table->timestamps();

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
        Schema::dropIfExists('product_results');

        Schema::table('tb_product', function (Blueprint $table) {
            $table->dropColumn('prices');
            $table->bigInteger('price')->default(0);
        });
    }
};
