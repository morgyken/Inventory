<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\OrdersReceivingRepository;

class OrderReceivingController extends AdminBaseController
{
    /*
     * Inject the necessary dependencies
     */
    public function __construct(OrdersReceivingRepository $repo)
    {
        $this->repo = $repo;
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store($storeId, $orderId)
    {
        $this->repo->create($storeId, $orderId);

        flash('Items have been received successfully', 'success');

        return redirect()->back();
    }
}
