<?php

namespace Ignite\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;

class InventoryDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProductsTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(DepartmentsSeeder::class);
    }
}