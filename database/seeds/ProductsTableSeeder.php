<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 1; $i < 1000; $i++) {
            DB::table('products')->insert([
                'category_id' => $faker->numberBetween(1, 3),
                'code' => $faker->uuid,
                'is_stock' => '1',
                'is_active' => '1',
                'is_sale' => $faker->numberBetween(0, 1),
                'slug' => $faker->slug(),
                'title' => $faker->name,
                'brand' => $faker->randomElement(['Asus', 'Intel', 'Apple', 'Acer', 'HP']),
                'model' => $faker->name,
                'summary' => $faker->text,
                'description' => $faker->realText,
                'price' => $faker->numberBetween(1000, 5000),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        DB::statement("UPDATE products SET search = (setweight(to_tsvector(title), 'B') ||
            setweight(to_tsvector(brand), 'C') ||
            setweight(to_tsvector(model), 'A')) WHERE id > 0");
    }
}
