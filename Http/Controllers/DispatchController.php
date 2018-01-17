<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\DispatchesRepository;
use Ignite\Inventory\Repositories\OrdersRepository;


class DispatchController extends AdminBaseController
{
    protected $repo;

    public function __construct(DispatchesRepository $repo, OrdersRepository $ordersRepo)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->ordersRepo = $ordersRepo;
    }

    /*
     * Shows the details of a dispatched order
     */
    public function index($id)
    {
        $order = $this->ordersRepo->find($id);

        $store = $order->dispatchingStore;

        return view('inventory::store.orders.dispatch_orders', compact('order', 'store'));
    }

    /*
     * Dispatch an item into the database.
     */
    public function store($id)
    {
        $this->repo->dispatch();

        flash("Items disparched successfully", "success");

        return redirect()->back();
    }
}
