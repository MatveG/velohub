<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class UpdateVeloplaneta extends Command
{
    private const STOCK_CODE = 'planeta';
    private const XML_PATH = '/app/storage/xml/price.xml';

    protected $signature = 'update:veloplaneta';
    protected $description = 'Update Veloplaneta stocks';

    public function __construct()
    {
        parent::__construct();

        $this->runs = 0;
        $this->xml = parseXmlFile(self::XML_PATH);

        if (empty($this->xml->shop->offer)) {
            throw new \RuntimeException('XML file is empty: ' . self::XML_PATH);
        }
    }

    public function handle(): string
    {
        $this->resetStocks();

        foreach ($this->xml->shop->offer as $offer) {
            $product = Product::where('code', (string)$offer->vp_sku)->first();

            if ($product) {
                $product->update($this->formatData($offer));
                $this->runs++;
            }
        }

        return "Updated $this->runs products";
    }

    private function resetStocks(): void
    {
        Product::query()->update([
            'stocks' => [
                'planeta' => 0,
            ],
        ]);
    }

    private function formatData(object $offer): array
    {
        $rest = (int)$offer->rest;
        $is_stock = $rest > 0;
        $is_sale = (int)$offer->Discount > 0;
        $price = $is_sale ? (int)$offer->RRP_D : (int)$offer->RRP;
        $price_old = $is_sale ? (int)$offer->RRP : null;
        $stocks = [self::STOCK_CODE => $rest];

        return compact([
            'is_stock',
            'is_sale',
            'price',
            'price_old',
            'stocks',
        ]);
    }
}
