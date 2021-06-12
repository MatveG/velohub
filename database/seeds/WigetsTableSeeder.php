<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WigetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('widgets')->insert([
            'slug' => 'header-contacts',
            'title' => 'Contact details in Header',
            'text' => '
<strong>+38 (098) 100-10-67</strong>
<span class="ml-1 small">ПН-ПТ 10<sup>00</sup>-19<sup>00</sup></span>',
        ]);
        DB::table('widgets')->insert([
            'slug' => 'footer-contacts',
            'title' => 'Contacts details in Footer',
            'text' => '<p>
<strong><a href="call:+380981001067">+38 (098) 100-10-67</a></strong>
<br>
<i>ПН-СБ</i>: <b>9<sup>00</sup> - 19<sup>00</sup></b>, <i>ВС</i>: <b>выходной</b><br>
<br>
<span class="small">Заказы, оформленные в нерабочее время, обрабатываются на следующий рабочий день.</span>
</p>',
        ]);
        DB::table('widgets')->insert([
            'slug' => 'footer-address',
            'title' => 'Address details in Footer',
            'text' => '
<p>
  <b>Оболонь</b>:<br>
  Оболонский проспект, 52А
</p>
<p>
  <b>Теремки</b>:<br>
  ул. Академика Вильямса, 6-Г, оф. 57
</p>
<span class="small">Цены и наличие актуальны при оформлении заказа на сайте.</span>',
        ]);
    }
}
