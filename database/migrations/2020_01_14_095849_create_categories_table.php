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
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->default(0)->index();
            $table->integer('sorting')->default(0);
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_parent')->default(false);
            $table->string('latin')->nullable();
            $table->string('name')->nullable();
            $table->string('name_short')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->longText('text')->nullable();
            $table->json('settings')->nullable();
            $table->json('features')->nullable();
            $table->json('options')->nullable();
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
