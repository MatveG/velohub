<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Document;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
//    public function testJsonCartNewRoute()
//    {
//        $response = $this->getJson(
//            route('ajax.cart.new')
//        )->(['id' => Sku::first()->id]);
//        $response->assertStatus(200);
//    }

    public function testShopCompareRoute()
    {
        $category = Category::first();

        $response = $this->get(route('category.compare', ['latin' => $category->latin, 'id' => $category->id]));
        $response->assertStatus(200);
    }

    public function testShopIndexRoute()
    {
        $category = Category::first();

        $response = $this->get(route('category.index', ['latin' => $category->latin, 'id' => $category->id]));
        $response->assertStatus(200);
    }

    public function testShopSearchRoute()
    {
        $response = $this->get(route('category.search') . '?find=test');
        $response->assertStatus(200);
    }

    public function testProductShowRoute()
    {
        $product = Product::first();

        $response = $this->get(route('Product.show', ['latin' => $product->latin, 'id' => $product->id]));
        $response->assertStatus(200);
    }

    public function testMainContentRoute()
    {
        $content = Document::first();

        $response = $this->get(route('main.content', ['latin' => $content->latin]));
        $response->assertStatus(200);
    }

    public function testMainIndexRoute()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
    }

}
