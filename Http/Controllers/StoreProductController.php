<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\Store;
use Ignite\Inventory\Repositories\StoreProductsRepository;
use Ignite\Inventory\Repositories\StoresRepository;

class StoreProductController extends AdminBaseController
{
    protected $repo, $storeRepo;

    /*
     * Inject dependencies into the class
     */
    public function __construct(StoreProductsRepository $repo, StoresRepository $storeRepo)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->storeRepo = $storeRepo;
    }

    /*
     * Shows all the products in a store
     */
    public function index($id)
    {
        $store = $this->storeRepo->find($id);

        if(request()->has('search'))
        {
            $products = $store->products()->where('name', 'LIKE', '%' . strtolower(request('search')) . '%')->get();
        }
        else
        {
            $products = $store->products()->paginate(50);
        }

        return view('inventory::store.products.store_products', compact('store', 'products'));
    }
}
