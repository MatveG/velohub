<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariantsTableSeeder extends Seeder
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
            DB::table('variants')->insert([
                'product_id' => $i,
                'category_id' => $faker->numberBetween(1, 3),
                'is_active' => true,
                'is_stock' => true,
                'price' => 100,
                'surcharge' => 0,
                'stock' =>  $faker->numberBetween(0, 3),
                'weight' => 10,
                'code' => $faker->word(),
                'barcode' => $faker->randomAscii(),
                'parameters' => json_encode([
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
