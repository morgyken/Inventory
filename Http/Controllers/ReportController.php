<?php

namespace Ignite\Inventory\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Entities\InventoryPurchaseOrders;
use Ignite\Inventory\Entities\InventoryBatch;
use Ignite\Inventory\Entities\InventoryStock;
use Ignite\Inventory\Entities\InventoryStockAdjustment;
use Illuminate\Http\Request;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventorySalesReturn;
use Ignite\Inventory\Entities\InventoryDispensing;
use Carbon\Carbon;

class ReportController extends AdminBaseController  {

    public function print_lpo($id) {
        $lpo = InventoryPurchaseOrders::findOrFail($id);
        $pdf = \PDF::loadView('inventory::prints.lpo', ['order' => $lpo]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('LPO #' . $lpo->id . '.pdf');
    }

    public function printStockMvmnt() {
        $this->data['adjustments'] = InventoryStockAdjustment::all();
        $pdf = \PDF::loadView('inventory::prints.stock_mvmnt', ['data' => $this->data]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Stock Movement.pdf');
    }

    public function excelStockMvmnt() {
        $adjustments = \DB::table('inventory_stock_adjustments as a')
                ->join('inventory_products as p', 'p.id', '=', 'a.product')
                ->join('users as u', 'u.id', '=', 'a.user')
                ->select('p.name', 'a.opening_qty', 'a.quantity', 'a.method', 'a.type', 'u.username', 'a.reason', 'a.created_at')
                ->get();
        //array which will be passed into the Excel
        $adjArray = [];
        //Excel spreadsheet headers
        $adjArray[] = ['Item', 'Opening Stock Qty', 'Quantity Moved', 'Movement Type', 'In', 'By', 'Reason', 'Date'];

        foreach ($adjustments as $adj) {
            $adjArray[] = (array) $adj;
        }
        \Excel::create('stock_movement', function($excel) use ($adjArray) {
            $excel->setTitle('Stock Movement Report');
            $excel->setCreator('Collabmed')->setCompany('iClinic Software');
            $excel->setDescription('An overview of item stock changes over time');
            $excel->sheet('sheet1', function($sheet) use ($adjArray) {
                $sheet->fromArray($adjArray, null, 'A1', false, false);
            });
        })->download('csv');
    }

    public function dnote($id) {
        $del = InventoryBatch::find($id);
        $pdf = \PDF::loadView('inventory::prints.d_note', ['id' => $id, 'delivery' => $del]);
        $pdf->setPaper('a4', 'potrait');
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
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('lpo_delivery_note#' . $lpo->id . '.pdf');
    }

    public function receipt($id) {
        $this->data['sales'] = InventoryBatchProductSales::find($id);
        $min_height = 420;
        foreach ($this->data['sales']->goodies as $n) {
            $min_height+=20;
        }
        $pdf = \PDF::loadView('inventory::prints.rcpt', ['data' => $this->data]);
        $customPaper = array(0, 0, 300, $min_height);
        $pdf->setPaper($customPaper);
        return $pdf->stream('receipt_' . $id . '.pdf');
    }

    public function invoice($id) {
        $this->data['sales'] = InventoryBatchProductSales::find($id);
        $pdf = \PDF::loadView('inventory::prints.invoice', ['data' => $this->data]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('receipt_' . $id . '.pdf');
    }

    //Reports
    public function PrintSalesSummary(Request $request) {
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
        $pdf = \PDF::loadView('inventory::prints.sales', ['data' => $this->data]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('sales_summary.pdf');
    }

    //Sales Report
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
        return view('inventory::reports.salesreport')->with('data', $this->data);
    }

    //Item Sales Reports
    public function itemSales(Request $request) {
        $this->data['filter'] = null;
        if ($request->isMethod('post')) {
            $despensing = InventoryDispensing::query();
            if ($request->has('start')) {
                $despensing->where('created_at', '>=', $request->start);
                $this->data['filter']['from'] = (new \Date($request->start))->format('jS M Y');
            }
            if ($request->has('end')) {
                $despensing->where('created_at', '<=', $request->end);
                $this->data['filter']['to'] = (new \Date($request->end))->format('jS M Y');
            }
            $this->data['records'] = $despensing->get();
        } else {
            $this->data['records'] = InventoryDispensing::all();
        }
        return view('inventory::reports.item_sales')->with('data', $this->data);
    }

    //Reports
    public function PrintItemSales(Request $request) {
        $this->data['filter'] = null;
        if ($request->isMethod('post')) {
            $despensing = InventoryDispensing::query();
            if ($request->has('start')) {
                $despensing->where('created_at', '>=', $request->start);
                $this->data['filter']['from'] = (new \Date($request->start))->format('jS M Y');
            }
            if ($request->has('end')) {
                $despensing->where('created_at', '<=', $request->end);
                $this->data['filter']['to'] = (new \Date($request->end))->format('jS M Y');
            }
            $this->data['records'] = $despensing->get();
        } else {
            $this->data['records'] = $despensing = InventoryDispensing::all();
        }
        $pdf = \PDF::loadView('inventory::prints.item_sales', ['data' => $this->data]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('item_sales_summary.pdf');
    }

    //Expiry Date Report
    public function expiry(Request $request) {
        $this->data['filter'] = null;
        $batch_purchase = InventoryBatchPurchases::query();
        if ($request->has('scope')) {
            if ($request->scope !== null) {
                $scope = Carbon::now()->addMonths($request->scope);
                $batch_purchase->where('expiry_date', '<=', $scope);
            } else {
                $scope = Carbon::now();
                $batch_purchase->where('expiry_date', '>=', $scope);
            }
            $this->data['filter']['to'] = (new \Date())->format('jS M Y');
        }
        $this->data['records'] = $batch_purchase->get();
        return view('inventory::reports.expiry')->with('data', $this->data);
    }

    public function expiryPrint(Request $request) {
        $this->data['filter'] = null;
        $batch_purchase = InventoryBatchPurchases::query();
        if ($request->scope == 'null') {
            $scope = Carbon::now();
            $batch_purchase->where('expiry_date', '<>', $scope);
        } else {
            $scope = Carbon::now()->addMonths($request->scope);
            $batch_purchase->where('expiry_date', '<=', $scope);
        }
        $this->data['filter']['to'] = (new \Date())->format('jS M Y');
        $this->data['records'] = $batch_purchase->get();
        //pdf
        $pdf = \PDF::loadView('inventory::prints.expiry', ['data' => $this->data['records'], 'info' => $request]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Expiry Report.pdf');
    }

    public function stocks() {
        $this->data['stocks'] = InventoryStock::orderBy('quantity', 'asc')->get();
        return view('inventory::reports.stock')->with('data', $this->data);
    }

    public function printStockReport() {
        $this->data['stocks'] = InventoryStock::orderBy('quantity', 'asc')->get();
        //pdf
        $pdf = \PDF::loadView('inventory::prints.stock', ['data' => $this->data]);
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('Stock Report.pdf');
    }

    public function creditnote(Request $request) {
        $this->data['r'] = InventorySalesReturn::find($request->id);
        $sale = InventoryBatchProductSales::where('receipt', '=', $this->data['r']->receipt_no)->first();
        $this->data['disp'] = InventoryDispensing::where('batch', '=', $sale->id)
                ->where('product', '=', $this->data['r']->product)
                ->first();


        //pdf
        $pdf = \PDF::loadView('inventory::prints.cnote', ['data' => $this->data]);
        $pdf->setPaper('a4', 'potrait');
        //$customPaper = array(0, 0, 300, 300);
        //$pdf->setPaper($customPaper);
        return $pdf->stream('credit_note.pdf');
    }

    public function stockMovement() {
        $this->data['adjustments'] = InventoryStockAdjustment::all();
        return view('inventory::reports.stock_movement')->with('data', $this->data);
    }

}
