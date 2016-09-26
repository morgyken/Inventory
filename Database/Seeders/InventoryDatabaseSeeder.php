<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;

class InventoryDatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(ProductsTableSeeder::class);
        $this->call(SuppliersTableSeeder::class);
    }

}
