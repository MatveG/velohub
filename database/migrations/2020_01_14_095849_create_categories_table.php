<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->index();

            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_parent')->default(false)->index();

            $table->integer('ord');

            $table->string('title')->nullable();
            $table->string('title_short')->nullable();
            $table->string('slug')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->text('description')->nullable();

            $table->json('images')->default('[]');
            $table->json('settings')->default('{}');

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
        Schema::dropIfExists('categories');
    }
}
