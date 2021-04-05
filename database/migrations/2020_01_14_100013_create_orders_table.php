<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable()->index();
            $table->integer('status')->nullable()->index();
            $table->integer('payment')->nullable()->index();
            $table->integer('delivery')->nullable()->index();
            $table->float('discount')->nullable();
            $table->float('shipping')->nullable();
            $table->float('total')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->text('text')->nullable();
            $table->json('address')->nullable('{}');
            $table->json('products')->nullable('{}');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
