<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('categories')->insert([
            'parent_id' => '0',
            'sorting' => '1',
            'is_active' => '1',
//            'settings' => json_encode([
//                'filters_in_menu' => [
//                    0 => ['latin' => 'brand', 'column' => ''],
//                    1 => ['latin' => 'processor', 'column' => 'features'],
//                    2 => ['latin' => 'size', 'column' => 'options'],
//                ]
//            ]),
            'latin' => $faker->word(),
            'name' => $faker->word(),
            'name_short' => $faker->word(),
            'features' => json_encode([
                'processor' => [
                    'order' => 1,
                    'group' => 0,
                    'filter' => 1,
                    'range' => 0,
                    'title' => 'Процессор',
                    'units' => null,
                ],
                'ssd' => [
                    'order' => 3,
                    'group' => 0,
                    'filter' => 1,
                    'range' => 1,
                    'title' => 'SSD диск',
                    'units' => null,
                ],
                'ram' => [
                    'order' => 2,
                    'group' => 0,
                    'filter' => 1,
                    'range' => 0,
                    'title' => 'Оперативная память',
                    'units' => 'Гб',
                ],
            ]),
            'options' => json_encode([
                'size' => [
                    'order' => 1,
                    'filter' => 1,
                    'range' => 0,
                    'title' => 'Размер',
                ],
                'color' => [
                    'order' => 2,
                    'filter' => 1,
                    'range' => 0,
                    'title' => 'Цвет',
                ],
            ]),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '1',
            'sorting' => '2',
            'is_active' => '1',
            'latin' => $faker->word(),
            'name' => $faker->word(),
            'name_short' => $faker->word(),
            'features' => null,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '1',
            'sorting' => '3',
            'is_active' => '1',
            'latin' => $faker->word(),
            'name' => $faker->word(),
            'name_short' => $faker->word(),
            'features' => null,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '0',
            'sorting' => '2',
            'is_active' => '1',
            'latin' => $faker->word(),
            'name' => $faker->word(),
            'name_short' => $faker->word(),
            'features' => null,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '0',
            'sorting' => '3',
            'is_active' => '1',
            'latin' => $faker->word(),
            'name' => $faker->word(),
            'name_short' => $faker->word(),
            'features' => null,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }
}
