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
            $table->boolean('is_default')->default(false);
            $table->string('title')->nullable();
            $table->string('barcode')->nullable();
            $table->json('codes')->nullable();
            $table->json('options')->nullable();
            $table->json('stocks')->nullable();
            $table->json('prices')->nullable();
            $table->json('images')->nullable();
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
