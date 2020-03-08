<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_sku', function (Blueprint $table) {
          $table->bigInteger('cart_id')->unsigned();
          $table->bigInteger('sku_id')->unsigned();
          $table->integer('amount')->default('1');

          $table->unique(['cart_id', 'sku_id']);

          //$table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
          //$table->foreign('sku_id')->references('id')->on('skus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_sku');
    }
}
