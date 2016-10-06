<?php

namespace Ignite\Inventory\Providers;

use Ignite\Core\Providers\CoreRouteServiceProvider;

class RouteServiceProvider extends CoreRouteServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @var string
     */
    protected $prefix = 'inventory';

    /**
     * @var string
     */
    protected $namespace = 'Ignite\Inventory\Http\Controllers';

    /**
     * @var string
     */
    protected $alias = 'inventory';

    /**
     * @return string
     */
    protected function getModuleRoutes() {
        return __DIR__ . '/../Http/routes.php';
    }

    /**
     * @return string
     */
    protected function getApiRoutes() {
        return __DIR__ . '/../Http/apiRoutes.php';
    }
    protected function getFrontendRoutes()
    {
        return null;
    }
}
