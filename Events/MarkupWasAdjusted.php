<?php

namespace Ignite\Inventory\Events;

use Ignite\Inventory\Entities\InventoryBatch;
use Illuminate\Queue\SerializesModels;

class MarkupWasAdjusted {

    use SerializesModels;

    /**
     * @var InventoryBatch
     */
    public $batch;

    /**
     * MarkupWasAdjusted constructor.
     * @param InventoryBatch $batch
     */
    public function __construct(InventoryBatch $batch) {
        $this->batch = $batch;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn() {
        return [];
    }

}
