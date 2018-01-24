<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\StoreProducts;
use Ignite\Inventory\Repositories\DispatchesRepository;
use Ignite\Inventory\Repositories\OrdersRepository;


class DispatchController extends AdminBaseController
{
    protected $repo, $ordersRepo;

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

        $details = $order->details->transform(function($detail) use ($store){

            $available = $this->getAvailableQuantity($detail, $store->id);

            return [
                'id' => $detail->id,

                'available' => $available,

                'item' => $detail->product->name,

                'ordered' => $detail->quantity,

                'dispatched' => $detail->dispatched,

                'pending' => $detail->pending,

                'dispatch' => $this->getDispatchQuantity($available, $detail->quantity, $detail->dispatched)
            ];

        });

        return view('inventory::store.orders.dispatch_orders', compact('order', 'store', 'details'));
    }

    /*
     * Dispatch an item into the database.
     */
    public function store($id)
    {
        $this->repo->dispatch($id);

        flash("Items dispatched successfully", "success");

        return redirect()->back();
    }

    public function getAvailableQuantity($detail, $storeId)
    {
        $record = StoreProducts::firstOrCreate([
            'product_id' => $detail->product->id, 'store_id' => $storeId
        ]);

        return $record->quantity;
    }

    public function getDispatchQuantity($available, $ordered, $dispatched)
    {
        if($dispatched > 0)
        {
            return $ordered - $dispatched;
        }
        else
        {
            if($available == 0)
            {
                return 0;
            }

            if($available > 0 and $available < $ordered)
            {
                return $available;
            }

            return $ordered;
        }
    }
}
