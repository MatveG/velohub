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
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->text('description')->nullable();

            $table->json('images')->default('[]');
            $table->json('settings')->default('{}');

            $table->timestamps();
        });

        DB::statement("DROP TRIGGER IF EXISTS categories_keep_ord ON categories;");
        DB::statement("CREATE TRIGGER categories_keep_ord BEFORE DELETE OR UPDATE ON categories
        FOR EACH ROW EXECUTE PROCEDURE keep_ord();");

        DB::statement("DROP TRIGGER IF EXISTS categories_new_ord ON categories;");
        DB::statement("CREATE TRIGGER categories_new_ord BEFORE INSERT OR UPDATE ON categories
        FOR EACH ROW EXECUTE PROCEDURE new_ord();");
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
