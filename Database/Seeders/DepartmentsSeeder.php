<?php

namespace Ignite\Inventory\Database\Seeders;

use Ignite\Inventory\Entities\StoreDepartment;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /*
     * Run the database seeds.
     */
    public function run()
    {
        $departments = [
            'nursing', 'doctors', 'dental', 'optical', 'radiology', 'diagnostics',
            'laboratory', 'pharmacy', 'ultrasound', 'theatre', 'cafeteria', 'shop'
        ];

        foreach ($departments as $department)
        {
            StoreDepartment::create([
                'name' => $department
            ]);
        }
    }
}
