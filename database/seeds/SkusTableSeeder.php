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

        for($i = 1; $i <= 500; $i++) {
            DB::table('skus')->insert([
                'product_id' => $i,
                'category_id' => $faker->numberBetween(1, 3),
                'is_active' => true,
                'increment' => 0,
                'price' => 100,
                'stock' =>  $faker->numberBetween(0, 3),
                'weight' => 10,
                'code' => $faker->word(),
                'barcode' => $faker->randomAscii(),
                'options' => json_encode([
                    'size' => $faker->randomElement(['XS', 'S', 'M', 'L', 'XL']),
                    'color' => $faker->randomElement(['red', 'white', 'black', 'blue', 'gray', 'orange']),
                ]),
                'images' => json_encode([
                    '0' => '/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-1.jpg',
                    '1' => '/1-velosipedi/Pride/10000-super-motion-drive/super-motion-400-2.jpg',
                ]),
            ]);
        }
    }
}
