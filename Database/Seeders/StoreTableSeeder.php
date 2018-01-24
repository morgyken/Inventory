<?php

namespace Ignite\Inventory\Database\Seeders;

use Ignite\Inventory\Entities\Store;
use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = array(
            [ 'name' => 'Main Store', 'description' => 'the main store', 'main_store' => 1, 'delivery_store' => 1 ],
            [ 'name' => 'Pharmacy Store', 'description' => 'the pharmacy store' ],
            [ 'name' => 'Nursing Store', 'description' => 'the nursing store' ],
        );

        foreach ($stores as $store) {

            Store::create($store);
        }
    }
}
