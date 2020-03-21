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
            $table->bigInteger('user_id')->unsigned()->default(0)->index();
            $table->integer('status')->default(0)->index();
            $table->integer('payment')->default(0)->index();
            $table->integer('delivery')->default(0)->index();
            $table->float('discount')->default(0);
            $table->float('shipping')->default(0);
            $table->float('sum')->default(0);
            $table->jsonb('items')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->text('text')->nullable();
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
