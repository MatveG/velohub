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
            $table->boolean('is_default')->default(false)->index();
//            $table->string('title')->nullable();
            $table->string('barcode')->nullable();
            $table->jsonb('codes')->nullable();
            $table->jsonb('options')->nullable();
            $table->jsonb('stocks')->nullable();
            $table->jsonb('prices')->nullable();
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
