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
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->index();
            $table->bigInteger('category_id')->index();

            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_stock')->default(false)->index();
            $table->boolean('is_sale')->default(false)->index();

            $table->float('price')->nullable();
            $table->float('surcharge')->default(0);
            $table->float('weight')->nullable();

            $table->string('code');
            $table->string('barcode')->nullable();

            $table->json('images')->default('[]');
            $table->json('parameters')->default('{}');
            $table->json('stocks')->default('{}');
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
