<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVaucherProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('products_id')->unsigned();
            $table->integer('vouchers_id')->unsigned();
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('vouchers_id')->references('id')->on('vouchers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_products');
    }
}
