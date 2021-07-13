<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->index();
            $table->bigInteger('parent_id')->index();

            $table->boolean('is_required')->default(false)->index();
            $table->boolean('is_filter')->default(false)->index();

            $table->integer('ord');

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('units')->nullable();

            $table->json('values')->default(json_encode([]));
        });

        DB::statement("DROP TRIGGER IF EXISTS parameters_keep_ord ON parameters;");
        DB::statement("CREATE TRIGGER parameters_keep_ord BEFORE DELETE OR UPDATE ON parameters
        FOR EACH ROW EXECUTE PROCEDURE keep_ord();");

        DB::statement("DROP TRIGGER IF EXISTS parameters_new_ord ON parameters;");
        DB::statement("CREATE TRIGGER parameters_new_ord BEFORE INSERT OR UPDATE ON parameters
        FOR EACH ROW EXECUTE PROCEDURE new_ord();");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}
