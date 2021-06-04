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
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->index();
            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_parent')->default(false)->index();
            $table->integer('ord');
            $table->string('group')->nullable()->index();
            $table->string('link')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });

        DB::statement("DROP TRIGGER IF EXISTS menus_keep_ord ON menus;");
        DB::statement("CREATE TRIGGER menus_keep_ord BEFORE DELETE OR UPDATE ON menus
        FOR EACH ROW EXECUTE PROCEDURE keep_ord();");

        DB::statement("DROP TRIGGER IF EXISTS menus_new_ord ON menus;");
        DB::statement("CREATE TRIGGER menus_new_ord BEFORE INSERT OR UPDATE ON menus
        FOR EACH ROW EXECUTE PROCEDURE new_ord();");
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
