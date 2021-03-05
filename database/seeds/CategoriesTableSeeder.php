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
            'is_active' => true,
            'is_parent' => true,
            'ord' => '1',
            'slug' => $faker->word(),
            'title' => $faker->word(),
            'title_short' => $faker->word(),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '1',
            'ord' => '2',
            'is_active' => true,
            'slug' => $faker->word(),
            'title' => $faker->word(),
            'title_short' => $faker->word(),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '1',
            'ord' => '3',
            'is_active' => true,
            'slug' => $faker->word(),
            'title' => $faker->word(),
            'title_short' => $faker->word(),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '0',
            'ord' => '2',
            'is_active' => true,
            'is_parent' => true,
            'slug' => $faker->word(),
            'title' => $faker->word(),
            'title_short' => $faker->word(),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);

        DB::table('categories')->insert([
            'parent_id' => '0',
            'ord' => '3',
            'is_active' => true,
            'slug' => $faker->word(),
            'title' => $faker->word(),
            'title_short' => $faker->word(),
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }
}
