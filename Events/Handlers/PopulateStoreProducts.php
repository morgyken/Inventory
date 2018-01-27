<?php

namespace Ignite\Inventory\Events\Handlers;

use Ignite\Inventory\Events\StoreCreated;
use Ignite\Inventory\Repositories\StoreProductsRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PopulateStoreProducts
{
    /*
     * Create the event listener.
     */
    public function __construct(StoreProductsRepository $repo)
    {
        $this->repo = $repo;
    }

    /*
     * Handle the event.
     */
    public function handle(StoreCreated $event)
    {
        $store = $event->store;

        $this->repo->populate($store->load(['products', 'department']));
    }
}
