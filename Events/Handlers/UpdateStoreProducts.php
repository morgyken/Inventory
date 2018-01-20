<?php

namespace Ignite\Inventory\Events\Handlers;

use Ignite\Inventory\Events\OrderReceived;
use Ignite\Inventory\Repositories\StoreProductsRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateStoreProducts
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
    public function handle(OrderReceived $event)
    {
        $order = $event->order;

        $this->repo->update($order->store, $order->products);
    }
}
