<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->index();
            $table->bigInteger('category_id')->index();

            $table->boolean('is_parent')->default(false);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_filter')->default(false)->index();

            $table->integer('ord');

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('type')->nullable();
            $table->string('hint')->nullable();
            $table->string('units')->nullable();

            $table->json('values')->default(json_encode([]));
        });

        DB::statement("DROP TRIGGER IF EXISTS features_keep_ord ON features;");
        DB::statement("CREATE TRIGGER features_keep_ord BEFORE DELETE OR UPDATE ON features
        FOR EACH ROW EXECUTE PROCEDURE keep_ord();");

        DB::statement("DROP TRIGGER IF EXISTS features_new_ord ON features;");
        DB::statement("CREATE TRIGGER features_new_ord BEFORE INSERT OR UPDATE ON features
        FOR EACH ROW EXECUTE PROCEDURE new_ord();");
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
