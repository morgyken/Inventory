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


//AJAX ONLY routes
$router->get('products', ['uses' => 'ApiController@get_products', 'as' => 'get_products']);
$router->get('sales/receipt/data', ['uses' => 'ApiController@sale_recipt', 'as' => 'sales.sale.details']);
$router->get('get/products', ['uses' => 'ApiController@products', 'as' => 'get.products']);
$router->get('getstock', ['uses' => 'ApiController@getitemstock', 'as' => 'getstock']);
$router->get('customers/autofetch', ['uses' => 'ApiController@fetchCustomer', 'as' => 'cust.get']);
$router->get('batch/amount', ['uses' => 'ApiController@fetchBatchAmount', 'as' => 'batch.amount']);
$router->get('credit/rate', ['uses' => 'ApiController@creditSelling', 'as' => 'credit.rate']);
$router->get('approve/adjustment', ['uses' => 'ApiController@approveStockAdjustment', 'as' => 'adj_approve']);
$router->get('credit/clients', ['uses' => 'ApiController@creditClients', 'as' => 'clients']);
$router->get('credit/client/pln', ['uses' => 'ApiController@creditClientPLN', 'as' => 'client.pln']);
$router->get('supplier/batches', ['uses' => 'ApiController@supplier_batches', 'as' => 'supplier.batch']);

