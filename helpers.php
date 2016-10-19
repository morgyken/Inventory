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

use Dervis\Modules\Inventory\Entities\InventoryCategories;
use Dervis\Modules\Inventory\Entities\InventoryPaymentTerms;
use Dervis\Modules\Inventory\Entities\InventoryProducts;
use Dervis\Modules\Inventory\Entities\InventoryPurchaseOrders;
use Dervis\Modules\Inventory\Entities\InventorySupplier;
use Dervis\Modules\Inventory\Entities\InventoryTaxCategory;
use Dervis\Modules\Inventory\Entities\InventoryUnits;

if (!function_exists('get_product_categories')) {

    /**
     * Get product categories
     * @return mixed
     */
    function get_product_categories() {
        return InventoryCategories::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_category')) {

    /**
     * Get parent category
     * @param int|null $category
     * @return mixed
     */
    function get_category($category = null) {
        return InventoryCategories::findOrNew($category)->name;
    }

}
if (!function_exists('get_units_of_measure')) {

    /**
     * Get units of measurements
     * @return mixed
     */
    function get_units_of_measure() {
        return InventoryUnits::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_tax_groups')) {

    /**
     * Get tax categories
     * @return mixed
     */
    function get_tax_groups() {
        return InventoryTaxCategory::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_suppliers')) {

    /**
     * Get suppliers
     * @param int|null $id
     * @return mixed
     */
    function get_suppliers($id = null) {
        if (!empty($id)) {
            return InventorySupplier::findOrNew($id)->name;
        }
        return InventorySupplier::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_products')) {

    /**
     * Get products added
     * @param int|null $id
     * @return mixed
     */
    function get_products($id = null) {
        if (!empty($id)) {
            return InventoryProducts::findOrNew($id)->name;
        }
        return InventoryProducts::all()->pluck('name', 'id');
    }

}
if (!function_exists('get_payment_terms')) {

    /**
     * @param int|null $id
     * @return \Illuminate\Support\Collection|mixed
     */
    function get_payment_terms($id = null) {
        if (!empty($id)) {
            return InventoryPaymentTerms::findOrNew($id)->terms;
        }
        return InventoryPaymentTerms::all()->pluck('terms', 'id');
    }

}
if (!function_exists('get_purchase_orders')) {

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    function get_purchase_orders() {
        return InventoryPurchaseOrders::all();
    }

}
if (!function_exists('order_label')) {

    /**
     * @param $stat
     * @return string
     */
    function order_label($stat) {
        $return = null;
        switch ($stat) {
            case 0:
                $return = 'default';
                break;
            case 1:
                $return = 'success';
                break;
            default :
                $return = 'default';
        }
        return "label label-$return";
    }

}