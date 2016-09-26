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

namespace Ignite\Inventory\Events\Handlers;

use Ignite\Inventory\Events\MarkupWasAdjusted;
use Ignite\Inventory\Library\InventoryFunctions;

class AdjustMarkup {

    /**
     * Handle the event.
     *
     * @param \Ignite\Inventory\Events\MarkupWasAdjusted $event
     * @return void
     */
    public function handle(MarkupWasAdjusted $event) {
        return InventoryFunctions::apply_markup($event->batch);
    }

}
