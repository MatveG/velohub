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
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->index();
            $table->integer('status')->index();
            $table->integer('payment')->index();
            $table->integer('delivery')->index();
            $table->float('discount')->default(0);
            $table->float('shipping')->default(0);
            $table->float('total')->default(0);
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->text('text')->nullable();
            $table->json('address')->default('{}');
            $table->json('products')->default('[]');
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
