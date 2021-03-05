<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'index',
            'name' => 'Главная',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'dostavka',
            'name' => 'Доставка',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'garantija',
            'name' => 'Гарантия',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'servis',
            'name' => 'Сервис',
        ]);
        DB::table('documents')->insert([
            'is_active' => '1',
            'slug' => 'kontakti',
            'name' => 'Контакты',
        ]);
    }
}
