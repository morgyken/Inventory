<?php
namespace Ignite\Inventory\Repositories;

use Ignite\Inventory\Entities\StoreDepartment;

class StoreDepartmentsRepository
{
    /*
     * Returns all the definitions of the departments from the database
     */
    public function all()
    {
        return StoreDepartment::all();
    }

}