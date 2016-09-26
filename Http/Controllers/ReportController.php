<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: iClinic
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Entities\InventoryPurchaseOrders;
use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryStock;
use Illuminate\Http\Request;

class ReportController extends AdminBaseController  {

    public function print_lpo($id) {
        $lpo = InventoryPurchaseOrders::findOrFail($id);
        $pdf = \PDF::loadView('inventory::prints.lpo', ['order' => $lpo]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('LPO #' . $lpo->id . '.pdf');
    }

    public function dnote($id) {
        $del = InventoryBatch::find($id);
        $pdf = \PDF::loadView('inventory::prints.d_note', ['id' => $id, 'delivery' => $del]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('delivery_note#' . $del->id . '.pdf');
    }

    public function dnote_lpo($id) {
        $batch_id = \Session::get('last_receive');
        $this->data['lpo_id'] = $id;
        $this->data['this_entity'] = config('practice.name');
        $this->data['batch_id'] = $batch_id;
        $batch = InventoryBatch::find($batch_id);

        $lpo = InventoryPurchaseOrders::findOrFail($id);
        $pdf = \PDF::loadView('inventory::prints.d_note_lpo', ['order' => $lpo, 'batch' => $batch]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('lpo_delivery_note#' . $lpo->id . '.pdf');
    }

    public function receipt($id) {
        $this->data['sales'] = InventoryBatchProductSales::find($id);
        $pdf = \PDF::loadView('inventory::prints.receipt', ['data' => $this->data]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('receipt_' . $id . '.pdf');
    }

    public function invoice($id) {
        $this->data['sales'] = InventoryBatchProductSales::find($id);
        $pdf = \PDF::loadView('inventory::prints.invoice', ['data' => $this->data]);
        $pdf->setPaper('a4', 'Landscape');
        return $pdf->stream('receipt_' . $id . '.pdf');
    }

    //Reports
    public function timePeriodSales(Request $request) {
        $this->data['filter'] = null;
        if ($request->isMethod('post')) {
            $kowaski = InventoryBatchProductSales::query();
            if ($request->has('start')) {
                $kowaski->where('created_at', '>=', $request->start);
                $this->data['filter']['from'] = (new \Date($request->start))->format('jS M Y');
            }
            if ($request->has('end')) {
                $kowaski->where('created_at', '<=', $request->end);
                $this->data['filter']['to'] = (new \Date($request->end))->format('jS M Y');
            }
            $this->data['records'] = $kowaski->get();
        } else {
            $this->data['records'] = InventoryBatchProductSales::all();
        }
        return view('inventory::reports.sales')->with('data', $this->data);
    }

    public function lowStocks() {
        $this->data['stocks'] = InventoryStock::orderBy('quantity', 'asc')->get();
        return view('inventory::reports.stocks')->with('data', $this->data);
    }

}
