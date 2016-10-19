<?php

namespace Ignite\Inventory\Providers;

use Ignite\Inventory\Events\Handlers\AdjustMarkup;
use Ignite\Inventory\Events\MarkupWasAdjusted;
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
        ]
    ];

}
