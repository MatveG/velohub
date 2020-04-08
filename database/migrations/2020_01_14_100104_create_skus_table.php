<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skus', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_stock')->default(false)->index();
            //$table->boolean('is_sale')->default(false)->index();

            $table->float('price_change')->nullable();
            //$table->float('price_sale')->nullable();
            $table->integer('stock')->nullable();
            $table->float('weight')->nullable();

            $table->string('code')->nullable();
            $table->string('barcode')->nullable();

            $table->jsonb('options')->nullable();
            $table->text('images')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skus');
    }
}
