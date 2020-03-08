<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        for($i = 1; $i <= 1000; $i++) {
            DB::table('skus')->insert([
                'product_id' => $i,
                'category_id' => $faker->numberBetween(1, 3),
                'is_active' => true,
                'is_default' => true,
                'barcode' => $faker->randomAscii(),
                'title' => $faker->word(),
                'codes' => json_encode([
                    $faker->word(),
                    $faker->word(),
                ]),
                'options' => json_encode([
                    'size' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL']),
                    'color' => $faker->randomElement(['red', 'white', 'black', 'blue', 'gray', 'orange']),
                ]),
                'prices' => json_encode([
                    'retail' => $faker->numberBetween(1000, 5000),
                    'sale' => $faker->numberBetween(1000, 4500),
                    'club' => $faker->numberBetween(1000, 4900),
                ]),
                'stocks' => json_encode([
                    '1' => '5',
                    '2' => '3',
                    '3' => '0',
                ]),
                'images' => json_encode([
                    '0' => '/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-1.jpg',
                    '1' => '/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-2.jpg',
                ]),
            ]);
        }
    }
}
