<?php

namespace Ignite\Inventory\Events;

use Ignite\Inventory\Entities\Store;
use Illuminate\Queue\SerializesModels;

class StoreCreated
{
    use SerializesModels;

    public $store;

    /*
     * Create a new event instance.
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
