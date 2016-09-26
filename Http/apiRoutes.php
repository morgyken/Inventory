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


$ajax = [
    'namespace' => 'Ignite\Inventory\Http\Controllers',
    'as' => 'inventory.ajax.',
    'prefix' => 'inventory/ajax',
    'middleware' => ['ajax'],
];
//AJAX ONLY routes
Route::group($ajax, function() {
    Route::get('products', ['uses' => 'ApiController@get_products', 'as' => 'get_products']);
    Route::get('get/products', ['uses' => 'ApiController@products', 'as' => 'get.products']);
    Route::get('getstock', ['uses' => 'ApiController@getitemstock', 'as' => 'getstock']);
    Route::get('customers/autofetch', ['uses' => 'ApiController@fetchCustomer', 'as' => 'cust.get']);
    Route::get('batch/amount', ['uses' => 'ApiController@fetchBatchAmount', 'as' => 'batch.amount']);
    Route::get('credit/rate', ['uses' => 'ApiController@creditSelling', 'as' => 'credit.rate']);
    Route::get('approve/adjustment', ['uses' => 'ApiController@approveStockAdjustment', 'as' => 'adj_approve']);
});
