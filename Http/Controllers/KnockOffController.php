<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\KnockOffsRepository;
use Ignite\Inventory\Repositories\StoresRepository;

class KnockOffController extends AdminBaseController
{
    protected $repo, $storeRepo;

    /*
     * Inject any necessary dependencies
     */
    public function __construct(KnockOffsRepository $repo, StoresRepository $storeRepo)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->storeRepo = $storeRepo;
    }

    /*
     * Show the form for knocking off items.
     */
    public function index($storeId)
    {
        $store = $this->storeRepo->find($storeId);

        return view("inventory::store.knockoffs.knock_off_items", compact('store'));
    }

    /*
     * Knock off items from the inventory
     */
    public function store($storeId)
    {
        $this->repo->create($storeId);

        flash('Product(s) have been knocked off', 'success');

        return redirect()->back();
    }
}
