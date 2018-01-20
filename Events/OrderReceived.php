<?php

namespace Ignite\Inventory\Events;

use Ignite\Inventory\Entities\InventoryBatch;
use Illuminate\Queue\SerializesModels;

class OrderReceived
{
    use SerializesModels;

    public $order;

    /*
     * Create a new event instance.
     */
    public function __construct(InventoryBatch $order)
    {
        $this->order = $order;
    }
}
