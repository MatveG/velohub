<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->default(0)->index();

            $table->boolean('is_parent')->default(false)->index();
            $table->boolean('is_filter')->default(false)->index();
            //$table->boolean('is_required')->default(false)->index();
            //$table->boolean('is_ranged')->default(false)->index();
            //$table->boolean('is_multiple')->default(false)->index();

            $table->integer('sorting')->default(0);
            //$table->integer('accuracy')->default(0);

            $table->string('type')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('units')->nullable();

            $table->text('values')->default('[]');

            $table->json('settings')->nullable();

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
        Schema::dropIfExists('features');
    }
}
