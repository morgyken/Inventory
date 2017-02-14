<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Repositories\InventoryRepository;
use Ignite\Inventory\Entities\OrderToCollabmed;
use Ignite\Inventory\Entities\CollabmedOrderQuotation;
use Ignite\Inventory\Entities\CollabmedOrderQuotationDetails;
use Illuminate\Http\Request;

class CollabmedController extends AdminBaseController {

    /**
     * @var Request Incoming HTTP request
     */
    protected $request;

    /**
     * @var InventoryRepository
     */
    protected $inventoryRepository;

    public function __construct(Request $request, InventoryRepository $inventoryRepository) {
        parent::__construct();
        $this->request = $request;
        $this->inventoryRepository = $inventoryRepository;
    }

    public function sendToCollabmed() {
        if ($this->inventoryRepository->sendOrderToCollabmed($this->request)) {
            flash('Order has been sent to collabmed.. thank you');
            return redirect()->back();
        }
    }

    public function viewOrders() {
        $this->data['orders'] = OrderToCollabmed::all();
        return view('inventory::collabmed.orders', ['data' => $this->data]);
    }

    public function orderDetails() {
        $coll_order = OrderToCollabmed::find($this->request->id);
        $this->data['col_order'] = $this->request->id;
        $this->data['order'] = $coll_order->orders; //InventoryPurchaseOrders::findOrFail($coll_order->orders->id);
        return view('inventory::collabmed.order_details', ['data' => $this->data]);
    }

    public function Quotation() {
        $request = $this->request;
        $quot = new CollabmedOrderQuotation;
        $quot->supplier = $request->supplier;
        $quot->order = $request->order;
        $quot->save();

        foreach ($request->item as $key => $value) {
            $details = new CollabmedOrderQuotationDetails;
            $details->item = $value;
            $details->units_required = $request->required_units[$key];
            $details->quotation = $quot->id;
            $details->save();
        }

        flash('Quotation Request has been Sent to Supplier');
        return back();
    }

    public function submitQuote() {
        $request = $this->request;

        foreach ($request->item as $key => $value) {
            $details = CollabmedOrderQuotationDetails::whereQuotation($request->quotation)
                    ->whereItem($value)
                    ->get()
                    ->first();
            if ($request->unit_price[$key] > 0) {
                $details->unit_price = $request->unit_price[$key];
            }
            $details->save();
        }

        $quot = CollabmedOrderQuotation::find($request->quotation);
        $quot->status = 'negotiation';
        $quot->save();

        flash('Your Quote has been sent to collabmed..');
        return back();
    }

    public function acceptQuote() {
        $quot = CollabmedOrderQuotation::find($this->request->id);
        $quot->status = 'accepted';
        $quot->save();
        flash('Quote Accepted.. proceed to LPO');
        return back();
    }

    public function rejectQuote() {
        $quot = CollabmedOrderQuotation::find($this->request->id);
        $quot->status = 'rejected';
        $quot->save();
        flash('Quotation rejected..');
        return back();
    }

    public function QuotationsView() {
        $this->data['quots'] = CollabmedOrderQuotation::all();
        return view('inventory::collabmed.quotations', ['data' => $this->data]);
    }

    public function QuotationDetails() {
        $this->data['quot'] = CollabmedOrderQuotation::find($this->request->id);
        $this->data['supplier_account'] = \Auth::user()->supplier_account;
        return view('inventory::collabmed.quotation_details', ['data' => $this->data]);
    }

}
