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

        for($i = 1; $i < 500; $i++) {
            DB::table('products')->insert([
                'category_id' => $faker->numberBetween(1, 3),
                'is_stock' => '1',
                'is_active' => '1',
                'is_sale' => $faker->numberBetween(0, 1),
                'latin' => $faker->slug(),
                'name' => $faker->name,
                'brand' => $faker->randomElement(['Asus', 'Intel', 'Apple', 'Acer', 'HP', 'Razer']),
                'model' => $faker->name,
                'brief' => $faker->text,
                'text' => $faker->realText,
                'features' => json_encode([
                    'year' => $faker->randomElement([2018, 2019, 2020]),
                    'processor' => $faker->randomElement(['Intel', 'AMD']),
                    'ram' => $faker->randomElement([3, 6, 12, 24, 48]),
                    'ssd' => $faker->randomElement([16, 32, 64, 128, 258, 512, 1024, 2048, 4096]),
                    'os' =>  $faker->randomElement(['Windows', 'Linux', 'DOS']),
                    'options' => ['Wi-Fi', 'BT', 'scaner', 'more1', 'more2', 'more3'],
                ]),
                'prices' => json_encode([
                    'price-1' => $faker->numberBetween(1000, 5000),
                    'price-2' => $faker->numberBetween(1000, 4500),
                    'price-3' => $faker->numberBetween(1000, 4900),
                ]),
                'images' => json_encode([
                    '0' => '/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-1.jpg',
                    '1' => '/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-2.jpg',
                ]),
                'created_at' => NOW(),
                'updated_at' => NOW(),
            ]);
        }

        DB::statement("UPDATE products SET search = (setweight(to_tsvector(name), 'B') ||
            setweight(to_tsvector(brand), 'C') ||
            setweight(to_tsvector(model), 'A')) WHERE id > 0");
    }
}
