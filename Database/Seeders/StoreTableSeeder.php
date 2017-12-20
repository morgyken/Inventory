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
        $stores = [
            ['name' => 'MAIN STORE', 'description' => 'The main store'],
            ['name' => 'Pharmacy', 'description' => 'Pharmacy store'],
            ['name' => 'Nursing', 'description' => 'Nursing store'],
        ];
        foreach ($stores as $store) {
            Store::create($store);
        }
    }
}
