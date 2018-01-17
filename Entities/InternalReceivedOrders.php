<?php

namespace Ignite\Inventory\Entities;

use Illuminate\Database\Eloquent\Model;

class InternalReceivedOrders extends Model
{
    protected $guarded = [];

    protected $table = "inventory_store_received_orders";
}
