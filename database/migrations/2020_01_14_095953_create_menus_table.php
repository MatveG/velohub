<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->default(0)->index();
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_parent')->default(false)->index();
            $table->integer('sorting')->default('0');
            $table->string('group')->nullable()->index();
            $table->string('link')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('menus');
    }
}
