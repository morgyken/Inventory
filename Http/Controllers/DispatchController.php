<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Ignite\Inventory\Repositories\DispatchesRepository;
use Ignite\Inventory\Entities\InternalOrder;


class DispatchController extends AdminBaseController
{
    protected $request, $repo;

    public function __construct(DispatchesRepository $repo)
    {
        parent::__construct();

        $this->repo = $repo;
    }

    /*
     * Shows the detaisl of a dispatched order
     */
    public function index($id)
    {
        $order = InternalOrder::find($id);

        return view('inventory::store.orders.orders_dispatched', compact('order'));
    }

    /*
     * Shows the store to dispatch to
     */
    public function show($id)
    {
        $order = InternalOrder::find($id);

        return view('inventory::store.orders.orders_dispatch', compact('order'));
    }

    /**
     * Dispatch an item into the database.
     */
    public function store()
    {
        $this->repo->dispatchInternal();

        $store = InternalOrder::find(request('order_id'))->dispatchingStore->id;

        flash('Items Dispatched', 'success');

        return redirect()->route('inventory.store.received', $store);
    }
}
