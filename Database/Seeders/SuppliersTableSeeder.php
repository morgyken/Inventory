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

use Ignite\Inventory\Entities\InventorySupplier;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SuppliersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        for ($i = 0; $i < 5; $i++) {
            $faker = Factory::create();
            $company = new InventorySupplier;
            $company->name = $faker->company;
            $company->address = $faker->address;
            $company->post_code = '011000';
            $company->town = $faker->city;
            $company->street = $faker->streetName;
            $company->building = $faker->streetAddress;
            $company->telephone = $faker->phoneNumber;
            $company->mobile = $faker->phoneNumber;
            $company->email = $faker->email;
            $company->save();
        }
    }

}
