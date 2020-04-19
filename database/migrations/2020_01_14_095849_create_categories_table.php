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

            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_parent')->default(false)->index();

            $table->integer('sorting')->default(0);

            $table->string('title')->nullable();
            $table->string('title_short')->nullable();
            $table->string('latin')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();

            $table->text('description')->nullable();

            $table->text('images')->default('[]');
            $table->text('features')->default('[]');
            $table->text('parameters')->default('[]');
            $table->text('settings')->default('{}');

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
