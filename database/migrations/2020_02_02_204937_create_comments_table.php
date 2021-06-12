<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_id')->index();
            $table->bigInteger('user_id')->nullable()->index();
            $table->boolean('is_active')->default(false)->index();
            $table->smallInteger('rating')->default(0);
            $table->string('author')->nullable();
            $table->string('email')->nullable();
            $table->text('pros')->nullable();
            $table->text('cons')->nullable();
            $table->text('text')->nullable();
            $table->text('video')->nullable();
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
        Schema::dropIfExists('comments');
    }
}
