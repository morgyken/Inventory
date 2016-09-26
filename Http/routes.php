<?php

$route_params = [
    'middleware' => [ 'auth.admin', 'setup'],
    'prefix' => 'inventory',
    'as' => 'inventory.',
    'namespace' => 'Ignite\Inventory\Http\Controllers'];
Route::group($route_params, function() {
    Route::get('/', ['uses' => 'InventoryController@index', 'as' => 'index']);

    //sales
    Route::match(['post', 'get'], 'shopfront', ['uses' => 'SalesController@shopfront', 'as' => 'shopfront']);
    Route::get('sales/receipt/{id}', ['uses' => 'SalesController@receipt', 'as' => 'receipt']);
    Route::get('sales/receipts', ['uses' => 'SalesController@receipts', 'as' => 'sales.receipts']);

    Route::match(['post', 'get'], 'sales/return', ['uses' => 'SalesController@return_goods', 'as' => 'sales.return']);
    Route::get('sales/return/fillform', ['uses' => 'ApiController@fill_return_form', 'as' => 'sales.fillreturnform']);
    Route::get('sales/return/fetchqtysold', ['uses' => 'ApiController@qty_sold', 'as' => 'sales.qtysold']);
    //products
    Route::match(['post', 'get'], 'categories/products/{id?}', ['uses' => 'InventoryController@product_categories', 'as' => 'product_categories']);
    Route::match(['post', 'get'], 'categories/tax/{id?}', ['uses' => 'InventoryController@tax_categories', 'as' => 'tax_categories']);
    Route::match(['post', 'get'], 'categories/measurement/{id?}', ['uses' => 'InventoryController@units_of_measurement', 'as' => 'units_of_measurement']);
    Route::get('products/{id?}', ['uses' => 'InventoryController@products', 'as' => 'products']);
    Route::match(['post', 'get'], 'manage/products/{id?}', ['uses' => 'InventoryController@add_product', 'as' => 'add_product']);
    Route::get('store/products/available', ['uses' => 'InventoryController@view_stock', 'as' => 'view_stock']);
    //stock_adjustments
    Route::match(['get', 'post'], 'store/products/adjust/{id}', ['uses' => 'InventoryController@adjust_stock', 'as' => 'adjust_stock']);
    Route::match(['get', 'post'], 'store/products/stock_adjustments', ['uses' => 'InventoryController@stock_adjustments', 'as' => 'stock.adjustments']);
    //Discount, Price and Category Price
    Route::get('product/discount', ['uses' => 'InventoryController@setProductDiscount', 'as' => 'product.discount']);
    Route::get('product/discount/{id}/delete', ['uses' => 'InventoryController@delProductDiscount', 'as' => 'product.discount.del']);

    Route::get('product/price', ['uses' => 'InventoryController@setProductPrice', 'as' => 'product.price']);
    Route::get('product/price/{id}/delete', ['uses' => 'InventoryController@delProductPrice', 'as' => 'product.price.del']);
    Route::post('product/price/edit', ['uses' => 'InventoryController@editProductPrice', 'as' => 'product.price.edit']);

    Route::get('category/price', ['uses' => 'InventoryController@setCategoryPrice', 'as' => 'category.price']);
    Route::get('category/price/{id}/delete', ['uses' => 'InventoryController@delCategoryPrice', 'as' => 'category.price.del']);
///
    Route::match(['post', 'get'], 'item/price/save', ['uses' => 'InventoryController@saveItemPrices', 'as' => 'product.save_prod_price']);
    Route::match(['post', 'get'], 'product/discount/save', ['uses' => 'InventoryController@saveProductDiscount', 'as' => 'product.save_discount']);
    Route::match(['post', 'get'], 'category/price/save', ['uses' => 'InventoryController@saveCategoryPrice', 'as' => 'category.save_price']);
    Route::match(['post', 'get'], 'product/markup', ['uses' => 'InventoryController@markup', 'as' => 'product.markup']);
    Route::get('markup/{id}/delete', ['uses' => 'InventoryController@delMarkup', 'as' => 'product.markup.del']);
    //purchases add_items_lpo
    Route::get('purchase/order/details/{id}', ['uses' => 'InventoryController@order_details', 'as' => 'order_details']);
    Route::match(['post', 'get'], 'purchase/paymnent/terms/{id?}', ['uses' => 'InventoryController@payment_terms', 'as' => 'payment_terms']);
    Route::match(['post', 'get'], 'purchase/orders', ['uses' => 'InventoryController@purchase_orders', 'as' => 'purchase_orders']);
    Route::match(['post', 'get'], 'internalorders', ['uses' => 'InventoryController@internal_orders', 'as' => 'orders.internal']);
    Route::match(['post', 'get'], 'purchase/manager', ['uses' => 'InventoryController@add_lpo', 'as' => 'new_lpo']);
    Route::match(['get', 'post'], 'purchase/receive/{ref}', ['uses' => 'InventoryController@receive_lpo', 'as' => 'receive_from_lpo']);
    Route::match(['post', 'get'], 'purchase/direct/goods', ['uses' => 'InventoryController@receive_direct', 'as' => 'receive_direct']);
    Route::get('goods/receive', ['uses' => 'InventoryController@receive_goods', 'as' => 'receive_goods']);
    Route::get('goods/received/grns', ['uses' => 'InventoryController@grns', 'as' => 'grns']);
    Route::get('batch/{id}/details', ['uses' => 'InventoryController@batch_details', 'as' => 'batch.details']);
    Route::get('goods/delivered/{batch}', ['uses' => 'InventoryController@purchase_details', 'as' => 'purchase_details']);

    //suppliers
    Route::match(['post', 'get'], 'suppliers/manage/{id?}', ['uses' => 'InventoryController@add_edit_suppliers', 'as' => 'manage_suppliers']);
    Route::get('suppliers/view/{id?}', ['uses' => 'InventoryController@suppliers', 'as' => 'suppliers']);
    Route::match(['post', 'get'], 'suppliers/invoice', ['uses' => 'InventoryController@supplier_invoice', 'as' => 'suppliers.invoice']);
    Route::match(['post', 'get'], 'supplier/invoice/view/{id}', ['uses' => 'InventoryController@supplier_invoice_details', 'as' => 'suppliers.invoice.details']);

    //prints
    Route::get('print/lpo/{id}', ['uses' => 'ReportController@print_lpo', 'as' => 'print_lpo']);
    Route::get('direct/dnote/{id}', ['uses' => 'ReportController@dnote', 'as' => 'dnote']);
    Route::get('lpo/dnote/{id}', ['uses' => 'ReportController@dnote_lpo', 'as' => 'dnote_lpo']);
    Route::get('sales/receipt/print/{id}', ['uses' => 'ReportController@receipt', 'as' => 'sale.receipt.print']);
    Route::get('sales/receipt/invoice/print/{id}', ['uses' => 'ReportController@invoice', 'as' => 'sale.invoice.print']);
    //Approve LPO
    Route::get('lpo/approve/{id}', ['uses' => 'InventoryController@approveLPO', 'as' => 'approveLPO']);

    //reports
    Route::match(['post', 'get'], 'reports/sales', ['uses' => 'ReportController@timePeriodSales', 'as' => 'reports.sales']);
    Route::match(['post', 'get'], 'reports/stocks', ['uses' => 'ReportController@lowStocks', 'as' => 'reports.stocks']);
    //Fetchers

    Route::get('suggest/items', ['uses' => 'ApiController@pullProductSuggestions', 'as' => 'prod.tulus']);
});
