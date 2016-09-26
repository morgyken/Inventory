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

use Ignite\Inventory\Entities\Customer;
use Ignite\Inventory\Entities\InventoryProducts;
use Ignite\Inventory\Entities\InventoryBatchProductSales;
use Ignite\Inventory\Entities\InventoryDispensing;
use Ignite\Inventory\Entities\InventoryStockAdjustment;
use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use Ignite\Inventory\Entities\InventoryBatchPurchases;
use Ignite\Inventory\Entities\InventoryCategories;
use Ignite\Inventory\Entities\InventoryProductPrice;

class ApiController extends Controller {

    protected $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function products() {
        $found = collect();
        $ret = [];
        $term = $this->request->term['term'];
        if (!empty($term)) {
            $found = InventoryProducts::with(['prices' => function($query) {

                                }])->with(['stocks' => function($query) {

                                }])
                            ->where('name', 'like', "%$term%")->get();
        }
        $build = [];
        foreach ($found as $item) {
            $batchp = InventoryBatchPurchases::whereProduct($item->id)
                    ->whereActive(TRUE)
                    ->first();
            $this->data['item_prices'] = InventoryProductPrice::query()->where('product', '=', $item->id)->get();
            $active_price = 0;
            foreach ($this->data['item_prices'] as $product) {
                if ($product->price > $active_price) {
                    $active_price = $product->price;
                }
            }

            $expiry = empty($batchp->expiry_date) ? '' : ' |expiry: ' . $batchp->expiry_date;
            $stock_text = empty($item->stocks) ? '  Out of stock' : $item->stocks->quantity . ' in stock';
            $strngth_text = empty($item->strength) ? '' : ' | ' . $item->strength . $item->units->name;
            $build[] = [
                'text' => $item->name . '  - ' . $stock_text . $strngth_text . $expiry,
                'id' => $item->id,
                'batch' => empty($batchp->batch) ? 0 : $batchp->batch,
                'cash_price' => ceil(($item->categories->cash_markup + 100) / 100 * $active_price), //$item->prices->credit_price
                'credit_price' => ceil(($item->categories->credit_markup + 100) / 100 * $active_price),
                'o_price' => $active_price,
                'available' => empty($item->stocks) ? 0 : $item->stocks->quantity];
        }
        $ret['results'] = $build;
        return json_encode($ret);
    }

    public function get_products() {
        $ret = [];
        $term = $this->request->term['term'];
        if (!empty($term)) {
            $found = InventoryProducts::with(['prices' => function($query) {
                                    //$query->addSelect(['price', 'id']);
                                }])
                            ->select('id', 'name as text')
                            ->where('name', 'like', "%$term%")->get();
        }
        $ret['results'] = $found;
        return json_encode($ret);
    }

    public function getitemstock() {
        $prod = InventoryProducts::find($this->request->item);

        if (!empty($prod)) {
            $qty = $prod->stocks['quantity'];
        } else {
            $qty = 0;
        }
        $input_qty = $this->request->input_qty;

        if ($qty > 0 && $input_qty < $qty) {
            return "<i class='fa fa-check' style='color:green'></i><script type='text/javascript'> $('#save').prop('disabled', false);</script>";
        }if ($qty > 0 && $input_qty > $qty) {
            return "<i class='fa fa-times' style='color:red'></i>" . $qty . " available!<a target='blank' href='/inventory/store/products/adjust/" . $prod->id . "'> adjust?</a><script type='text/javascript'> $('#save').prop('disabled', true);</script>";
        } else {
            return "<i class='fa fa-times' style='color:red'></i>0 remaining! <a target='blank' href='/inventory/store/products/adjust/" . $prod->id . "'>adjust?</a><script type='text/javascript'> $('#save').prop('disabled', true);</script>";
        }
    }

    public function shiftBatchPrice($item) {
        $active_batch = InventoryBatchPurchases::query()
                ->where('product', '=', $item)
                ->where('active', '=', TRUE)
                ->first();
    }

    public function receiptData() {
        $prod = InventoryProducts::find($this->request->item);
        $qty = $prod->stocks['quantity'];
        if ($qty > 0) {
            return "<i class='fa fa-info' style='color:green'>" . $qty . "</i>";
        } else {
            return "<i class='fa fa-exclamation' style='color:red'>0 stock</i> ";
        }
    }

    public function fill_return_form() {
        $batch_sale = InventoryBatchProductSales::where('receipt', '=', $this->request->rcpt)->first();

        $sale = InventoryDispensing::where('batch', '=', $batch_sale['id'])->get();
        echo"<td><select name='product' id='product' onclick='fetchQtySold(this.value)' class='form-control'>";
        foreach ($sale as $s) {
            echo "<option value='{$s->products->id}'>{$s->products->name}</option>";
        }
        echo"</select> </td> <td><input type='number' name='qty' class='form-control' id='qty' placeholder='Quantity Returned'/> <span id='response'></span> </td> <td><textarea placeholder='Why is the product being returned?' name='reason' class='form-control'></textarea></td>";
    }

    public function qty_sold() {
        $batch_sale = InventoryBatchProductSales::where('receipt', '=', $this->request->rcpt)->first();

        $product_sale = InventoryDispensing::where('batch', '=', $batch_sale['id'])
                ->where('product', '=', $this->request->product_id)
                ->first();
        if ($product_sale['quantity'] > 0) {
            $msg = '<br/><div class="alert alert-warning" role="alert"><strong>' . $product_sale['quantity'] . '</strong> of this item were sold @<b>' . $product_sale['price'] . '</b> per unit</div>';
        }
        return $msg;
    }

    public function fetchCustomer(Request $request) {
        //$customer = Customer::query();
        $result = Customer::where('phone', 'LIKE', '%' . $request->key . '%')->get();

        //return $results;
        echo '<table class="table table-striped" id="suggestions">';
        foreach ($result as $r) {
            $fn = $r->first_name;
            $phne = $r->phone;
            $ln = $r->last_name;
            $email = $r->email;
            echo '<tr><td onClick="setValue(\'' . $phne . '\',\'' . $email . '\', \'' . $fn . '\', \'' . $ln . '\')">' . $phne . '</td></tr>';
        }
        echo'</table>';
    }

    public function pullProductSuggestions(Request $request) {
        //$customer = Customer::query();
        $r = InventoryProducts::where('name', 'LIKE', '%' . $request->key . '%')->get();
        $i = $request->i;
        //return $results;
        echo '<table class="table table-striped" id="suggestions">';
        foreach ($r as $r) {
            $name = $r->name;
            $id = $r->id;
            $price = $r->prices->price;
            echo '<tr><td onClick="setValue(\'' . $name . '\',' . $price . ', ' . $i . ', ' . $id . ')">' . $name . '</td></tr>';
        }
        echo'</table>';
    }

    public function fetchBatchAmount(Request $request) {
        $bp = InventoryBatchPurchases::query();
        $this->data['batch_purchases'] = $bp->where('batch', '=', $request->batch)->get();
        $amnt = 0;
        foreach ($this->data['batch_purchases'] as $bp) {
            $total = $bp->quantity * $bp->package_size * $bp->unit_cost;
            $amnt+=$total;
        }
        return $amnt;
    }

    public function creditSelling(Request $request) {
        $item = InventoryProducts::find($request->item);
        $cat = InventoryCategories::find($item->category)->first();
        $p = InventoryProductPrice::query();

        $price_query = $p->where('product', '=', $item->id)->get()->first();
        $pricex = $price_query->selling;

        $deficit = (($cat->credit_markup - $cat->cash_markup) + 100) / 100;


        return $pricex * $deficit;
    }

    public function approveStockAdjustment(Request $request) {
        $adj = InventoryStockAdjustment::find($request->id);
        $adj->approved = 'yes';
        $adj->save();

        return "<i class='fa fa-check' style='color:green'>approved</i>";
    }

}
