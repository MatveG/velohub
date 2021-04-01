<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variants', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();

            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_stock')->default(false)->index();
            $table->boolean('is_sale')->default(false)->index();

            $table->integer('stock')->default(0);
            $table->float('price')->nullable();
            $table->float('surcharge')->default(0);
            $table->float('weight')->nullable();

            $table->string('code')->nullable();
            $table->string('barcode')->nullable();

            $table->text('images')->nullable();
            $table->json('parameters')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variants');
    }
}
