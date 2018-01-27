<?php

namespace Ignite\Inventory\Providers;

use Ignite\Inventory\Events\Handlers\AdjustMarkup;
use Ignite\Inventory\Events\Handlers\PopulateStoreProducts;
use Ignite\Inventory\Events\Handlers\UpdateStoreProducts;
use Ignite\Inventory\Events\MarkupWasAdjusted;
use Ignite\Inventory\Events\OrderReceived;
use Ignite\Inventory\Events\StoreCreated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $listen = [

        MarkupWasAdjusted::class => [
            AdjustMarkup::class,
        ],

        OrderReceived::class => [
            UpdateStoreProducts::class
        ],

        StoreCreated::class => [
            PopulateStoreProducts::class
        ]
    ];

}
