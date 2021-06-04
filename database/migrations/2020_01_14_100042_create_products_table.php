<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->index();

            $table->boolean('is_active')->default(false)->index();
            $table->boolean('is_stock')->default(false)->index();
            $table->boolean('is_sale')->default(false)->index();

            $table->integer('warranty')->nullable();

            $table->float('price')->nullable();
            $table->float('price_old')->nullable();
            $table->float('weight')->nullable();

            $table->string('code')->nullable();
            $table->string('barcode')->nullable();
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('seo_title')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('sale_text')->nullable();

            $table->text('summary')->nullable();
            $table->text('description')->nullable();

            $table->json('images')->default('[]');
            $table->json('videos')->default('[]');
            $table->json('files')->default('[]');
            $table->json('stocks')->default('{}');
            $table->json('features')->default('{}');
            $table->json('settings')->default('{}');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE products ADD COLUMN search tsvector;");
        DB::statement("CREATE INDEX products_search_index ON products USING GIN(search);");

        DB::statement("CREATE OR REPLACE FUNCTION sync_search() RETURNS TRIGGER AS $$
        BEGIN
            new.search = (setweight(to_tsvector(COALESCE(NEW.title, '')), 'B') ||
                setweight(to_tsvector(COALESCE(NEW.brand, '')), 'C') ||
                setweight(to_tsvector(COALESCE(NEW.model, '')), 'A'));
            RETURN NEW;
        END
        $$ LANGUAGE 'plpgsql';");

        DB::statement("DROP TRIGGER IF EXISTS products_sync_search ON features;");
        DB::statement("CREATE TRIGGER products_sync_search BEFORE INSERT OR UPDATE ON products
        FOR EACH ROW EXECUTE PROCEDURE sync_search();");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
