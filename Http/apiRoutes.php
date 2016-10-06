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
$router->get('products', ['uses' => 'ApiController@get_products', 'as' => 'get_products']);
$router->get('get/products', ['uses' => 'ApiController@products', 'as' => 'get.products']);
$router->get('getstock', ['uses' => 'ApiController@getitemstock', 'as' => 'getstock']);
$router->get('customers/autofetch', ['uses' => 'ApiController@fetchCustomer', 'as' => 'cust.get']);
$router->get('batch/amount', ['uses' => 'ApiController@fetchBatchAmount', 'as' => 'batch.amount']);
$router->get('credit/rate', ['uses' => 'ApiController@creditSelling', 'as' => 'credit.rate']);
$router->get('approve/adjustment', ['uses' => 'ApiController@approveStockAdjustment', 'as' => 'adj_approve']);

