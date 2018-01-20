<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class StoreProducts extends Model
{
    protected $table = "inventory_store_products";

    protected $guarded = [ 'id' ];
}
