<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrderProductVauchers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product_voucher', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('orders_id')->unsigned();
            $table->integer('vouchers_id')->unsigned();
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
            $table->index('vouchers_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product_voucher');
    }
}
