<?php

namespace Ignite\Inventory\Events\Handlers;

use Ignite\Inventory\Events\MarkupWasAdjusted;

class AdjustMarkup {

    public function __construct(\Ignite\Inventory\Repositories\InventoryRepository $repo) {
        $this->repo = $repo;
    }

    /**
     * Handle the event.
     *
     * @param \Ignite\Inventory\Events\MarkupWasAdjusted $event
     * @return void
     */
    public function handle(MarkupWasAdjusted $event) {

        return $this->repo->apply_markup($event->batch);
    }

}
