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

        /*
--
-- CREATE OR REPLACE FUNCTION keep_order() RETURNS TRIGGER AS $$
-- DECLARE
--     query TEXT;
-- BEGIN
--     IF TG_OP = 'DELETE' OR NEW.parent_id != OLD.parent_id THEN
--         query := format('UPDATE %I
--         SET ord = ord - 1
--         WHERE parent_id = $1.parent_id
--         AND ord > $1.ord', TG_TABLE_NAME);
--         EXECUTE query USING OLD;
--     END IF;
--     IF TG_OP = 'DELETE' THEN
--         RETURN OLD;
--     end if;
--     RETURN NEW;
-- END
-- $$ LANGUAGE 'plpgsql';
--
-- DROP TRIGGER IF EXISTS features_keep_order ON features;
-- CREATE TRIGGER features_keep_order BEFORE DELETE OR UPDATE ON features
--     FOR EACH ROW EXECUTE PROCEDURE keep_order();
--
--
-- CREATE OR REPLACE FUNCTION order_value() RETURNS TRIGGER AS $$
-- DECLARE
--     _max_ord integer;
-- BEGIN
--     IF TG_OP = 'INSERT' OR NEW.parent_id != OLD.parent_id THEN
--         SELECT MAX(ord) INTO _max_ord
--         FROM features
--         WHERE parent_id = NEW.parent_id;
--
--         IF (_max_ord IS NULL) THEN
--             _max_ord = 0;
--         END IF;
--
--         NEW.ord = _max_ord + 1;
--     END IF;
--     RETURN NEW;
-- END
-- $$ LANGUAGE 'plpgsql';
--
-- DROP TRIGGER IF EXISTS features_order_value ON features;
-- CREATE TRIGGER features_order_value BEFORE INSERT OR UPDATE ON features
--     FOR EACH ROW EXECUTE PROCEDURE order_value();

        */
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
