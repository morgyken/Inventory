<?php

namespace Ignite\Inventory\Database\Seeders;

use Ignite\Inventory\Entities\InventoryCategories;
use Ignite\Inventory\Entities\InventoryPaymentTerms;
use Ignite\Inventory\Entities\InventoryProductPrice;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\InventoryTaxCategory;
use Ignite\Inventory\Entities\InventoryUnits;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $product_categories = ['Drugs', 'Eye-wear', 'Minerals'];
        foreach ($product_categories as $category) {
            $in = new InventoryCategories;
            $in->name = $category;
            $in->cash_markup = 34;
            $in->credit_markup = 40;
            $in->save();
        }
        $tax_categories = ['None' => 0, 'VAT' => '0.16', 'Special' => '0.002'];
        foreach ($tax_categories as $key => $category) {
            $in = new InventoryTaxCategory;
            $in->name = $key;
            $in->rate = $category;
            $in->save();
        }
        $uom = ['ltrs', 'kgs', 'mm', 'ml', 'g', 'mmol', 'carton', 'box', 'tray', 'tonnes'];
        foreach ($uom as $unit) {
            $in = new InventoryUnits;
            $in->name = $unit;
            $in->save();
        }
        $payment_terms = ['Pay after delivery', 'Pay after 30 days', 'Pay on invoice'];
        foreach ($payment_terms as $term) {
            $in = new InventoryPaymentTerms;
            $in->terms = $term;
            $in->save();
        }
        $faker = Factory::create();
        for ($i = 0; $i < 200; $i++) {
            $in = new InventoryProducts;
            $in->name = ucfirst($faker->unique()->domainWord);
            $in->category = $faker->numberBetween(1, count($product_categories));
            $in->unit = $faker->numberBetween(1, count($uom));
            $in->tax_category = 1;
            $in->save();
            /** @var InventoryProductPrice $price */
            $price = InventoryProductPrice::firstOrNew(['product' => $in->id]);
            $price->price = $faker->numberBetween(10, 400);
            $price->selling = $price->price * 1.11;
            $price->ins_price = $price->selling + random_int(1, $price->selling);
            $price->save();
            $in->stocks()->create(['quantity' => random_int(500, 20000)]);
        }
    }

}
