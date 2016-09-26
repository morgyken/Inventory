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

namespace Ignite\Inventory\Library;

/**
 * Description of Validation
 *
 * @author Samuel Dervis <samueldervis@gmail.com>
 */
class Validation {

    /**
     * Supplier validation tendons
     * @return array
     */
    public static function add_supplier() {
        return [
            'name' => 'required',
            'address' => 'required',
            'telephone' => 'required',
            'email' => 'bail|email|required',
            'town' => 'required',
        ];
    }

    /**
     * Product validation
     * @return array
     */
    public static function add_product_category() {
        return [
            'name' => 'required',
        ];
    }

    /**
     * Add tax category
     * @return array
     */
    public static function add_tax_category() {
        return [
            'name' => 'required',
            'rate' => 'required',
        ];
    }

    /**
     * Add unit of measurement
     * @return array
     */
    public static function add_unit_of_measure() {
        return [
            'name' => 'required',
            'description' => '',
        ];
    }

    /**
     * Add product
     * @return array
     */
    public static function add_product() {
        return [
            'name' => 'required',
            'description' => '',
            'category' => 'required',
            'unit' => 'required',
            'tax' => '',
                // 'unit_cost'=>'require'
        ];
    }

    public static function adjust_stock() {
        return [
            'quantity' => 'required|numeric',
            'reason' => 'required',
        ];
    }

}
