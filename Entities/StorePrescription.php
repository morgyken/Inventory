<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class StorePrescription extends Model
{
    protected $guarded = ['id'];

    protected $table = 'inventory_store_prescriptions';
}
