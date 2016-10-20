<?php

$router->get('/', ['uses' => 'InventoryController@index', 'as' => 'index']);

//sales
$router->match(['post', 'get'], 'shopfront', ['uses' => 'SalesController@shopfront', 'as' => 'shopfront']);
$router->match(['post', 'get'], 'shopfront/credit', ['uses' => 'SalesController@shopfront_credit', 'as' => 'shopfront.credit']);
$router->match(['post', 'get'], 'clients/credit/{id}', ['uses' => 'SalesController@clients', 'as' => 'clients.credit']);
$router->match(['post', 'get'], 'clients/{id}', ['uses' => 'SalesController@show_clients', 'as' => 'clients.all']);
$router->get('client/purge/{id}', ['uses' => 'SalesController@purge_client', 'as' => 'clients.credit.purge']);

$router->get('sales/receipt/{id}', ['uses' => 'SalesController@receipt', 'as' => 'receipt']);
$router->get('sales/receipts', ['uses' => 'SalesController@receipts', 'as' => 'sales.receipts']);

$router->match(['post', 'get'], 'sales/return', ['uses' => 'SalesController@return_goods', 'as' => 'sales.return']);
$router->get('sales/return/fillform', ['uses' => 'ApiController@fill_return_form', 'as' => 'sales.fillreturnform']);
$router->get('sales/return/fetchqtysold', ['uses' => 'ApiController@qty_sold', 'as' => 'sales.qtysold']);
$router->get('sales/creditnote/{id}', ['uses' => 'ReportController@creditnote', 'as' => 'sales.cnote']);
//products
$router->match(['post', 'get'], 'categories/products/{id?}', ['uses' => 'InventoryController@product_cat', 'as' => 'product_cat']);
$router->post('categories/save', ['as' => 'product_cat.save', 'uses' => 'InventoryController@product_cat_save']);
$router->match(['post', 'get'], 'categories/tax/{id?}', ['uses' => 'InventoryController@tax_categories', 'as' => 'tax_categories']);
$router->match(['post', 'get'], 'categories/measurement/{id?}', ['uses' => 'InventoryController@units_of_measurement', 'as' => 'units_of_measurement']);
$router->get('products/{id?}', ['uses' => 'InventoryController@products', 'as' => 'products']);
$router->match(['post', 'get'], 'manage/products/{id?}', ['uses' => 'InventoryController@add_product', 'as' => 'add_product']);
$router->get('store/products/available', ['uses' => 'InventoryController@view_stock', 'as' => 'view_stock']);
//stock_adjustments
$router->match(['get', 'post'], 'store/products/adjust/{id}', ['uses' => 'InventoryController@adjust_stock', 'as' => 'adjust_stock']);
$router->match(['get', 'post'], 'store/products/stock_adjustments', ['uses' => 'InventoryController@stock_adjustments', 'as' => 'stock.adjustments']);
//Discount, Price and Category Price
$router->get('product/discount', ['uses' => 'InventoryController@setProductDiscount', 'as' => 'product.discount']);
$router->get('product/discount/{id}/delete', ['uses' => 'InventoryController@delProductDiscount', 'as' => 'product.discount.del']);

$router->get('product/price', ['uses' => 'InventoryController@setProductPrice', 'as' => 'product.price']);
$router->get('product/price/{id}/delete', ['uses' => 'InventoryController@delProductPrice', 'as' => 'product.price.del']);
$router->post('product/price/edit', ['uses' => 'InventoryController@editProductPrice', 'as' => 'product.price.edit']);

$router->get('category/price', ['uses' => 'InventoryController@setCategoryPrice', 'as' => 'category.price']);
$router->get('category/price/{id}/delete', ['uses' => 'InventoryController@delCategoryPrice', 'as' => 'category.price.del']);
///
$router->match(['post', 'get'], 'item/price/save', ['uses' => 'InventoryController@saveItemPrices', 'as' => 'product.save_prod_price']);
$router->match(['post', 'get'], 'product/discount/save', ['uses' => 'InventoryController@saveProductDiscount', 'as' => 'product.save_discount']);
$router->match(['post', 'get'], 'category/price/save', ['uses' => 'InventoryController@saveCategoryPrice', 'as' => 'category.save_price']);
$router->match(['post', 'get'], 'product/markup', ['uses' => 'InventoryController@markup', 'as' => 'product.markup']);
$router->get('markup/{id}/delete', ['uses' => 'InventoryController@delMarkup', 'as' => 'product.markup.del']);
//purchases add_items_lpo
$router->get('purchase/order/details/{id}', ['uses' => 'InventoryController@order_details', 'as' => 'order_details']);
$router->match(['post', 'get'], 'purchase/paymnent/terms/{id?}', ['uses' => 'InventoryController@payment_terms', 'as' => 'payment_terms']);
$router->match(['post', 'get'], 'purchase/orders', ['uses' => 'InventoryController@purchase_orders', 'as' => 'purchase_orders']);
$router->match(['post', 'get'], 'internalorders', ['uses' => 'InventoryController@internal_orders', 'as' => 'orders.internal']);
$router->match(['post', 'get'], 'purchase/manager', ['uses' => 'InventoryController@add_lpo', 'as' => 'new_lpo']);
$router->match(['get', 'post'], 'purchase/receive/{ref}', ['uses' => 'InventoryController@receive_lpo', 'as' => 'receive_from_lpo']);
$router->match(['post', 'get'], 'purchase/direct/goods', ['uses' => 'InventoryController@receive_direct', 'as' => 'receive_direct']);
$router->get('goods/receive', ['uses' => 'InventoryController@receive_goods', 'as' => 'receive_goods']);
$router->get('goods/received/grns', ['uses' => 'InventoryController@grns', 'as' => 'grns']);
$router->get('batch/{id}/details', ['uses' => 'InventoryController@batch_details', 'as' => 'batch.details']);
$router->get('goods/delivered/{batch}', ['uses' => 'InventoryController@purchase_details', 'as' => 'purchase_details']);

//suppliers
$router->match(['post', 'get'], 'suppliers/manage/{id?}', ['uses' => 'InventoryController@add_edit_suppliers', 'as' => 'manage_suppliers']);
$router->get('suppliers/view/{id?}', ['uses' => 'InventoryController@suppliers', 'as' => 'suppliers']);
$router->match(['post', 'get'], 'suppliers/invoice', ['uses' => 'InventoryController@supplier_invoice', 'as' => 'suppliers.invoice']);
$router->match(['post', 'get'], 'supplier/invoice/view/{id}', ['uses' => 'InventoryController@supplier_invoice_details', 'as' => 'suppliers.invoice.details']);

//prints
$router->get('print/lpo/{id}', ['uses' => 'ReportController@print_lpo', 'as' => 'print_lpo']);
$router->get('direct/dnote/{id}', ['uses' => 'ReportController@dnote', 'as' => 'dnote']);
$router->get('lpo/dnote/{id}', ['uses' => 'ReportController@dnote_lpo', 'as' => 'dnote_lpo']);
$router->get('sales/receipt/print/{id}', ['uses' => 'ReportController@receipt', 'as' => 'sale.receipt.print']);
$router->get('sales/receipt/invoice/print/{id}', ['uses' => 'ReportController@invoice', 'as' => 'sale.invoice.print']);
$router->get('print/sales/{start}/{end}', ['uses' => 'ReportController@PrintSalesSummary', 'as' => 'inv.sales.print']);
$router->get('print/sales/', ['uses' => 'ReportController@PrintSalesSummary', 'as' => 'inv.sales.all.print']);

$router->get('print/item/sales/{start}/{end}', ['uses' => 'ReportController@PrintItemSales', 'as' => 'inv.item.sales.print']);
$router->get('print/item/sales/', ['uses' => 'ReportController@PrintItemSales', 'as' => 'inv.item.sales.all.print']);

$router->get('print/stock/movement/', ['uses' => 'ReportController@printStockMvmnt', 'as' => 'stock.movement.print']);
$router->get('stock/expiry/{type}/{scope}', ['uses' => 'ReportController@expiryPrint', 'as' => 'stock.expiry.print']);
$router->get('stock/report/print', ['uses' => 'ReportController@printStockReport', 'as' => 'stock.report.print']);
//Excel
$router->get('excel/stock/movement/', ['uses' => 'ReportController@excelStockMvmnt', 'as' => 'stock.movement.worksheet']);
$router->get('expiry/{type}/{scope}/{start}/{end}', ['uses' => 'ReportController@expiry', 'as' => 'stock.expiry.worksheet']);
//Approve LPO
$router->get('lpo/approve/{id}', ['uses' => 'InventoryController@approveLPO', 'as' => 'approveLPO']);

//reports
$router->match(['post', 'get'], 'sales/report', ['uses' => 'ReportController@timePeriodSales', 'as' => 'reports.sales']);
$router->match(['post', 'get'], 'product/sales/report', ['uses' => 'ReportController@itemSales', 'as' => 'reports.sales.product']);
$router->match(['post', 'get'], 'reports/stocks', ['uses' => 'ReportController@stocks', 'as' => 'reports.stocks']);
$router->match(['post', 'get'], 'reports/stock/movement', ['uses' => 'ReportController@stockMovement', 'as' => 'reports.stocks.movement']);
$router->match(['post', 'get'], 'reports/stock/expiry', ['uses' => 'ReportController@expiry', 'as' => 'reports.stocks.expiry']);
//Fetchers

$router->get('suggest/items', ['uses' => 'ApiController@pullProductSuggestions', 'as' => 'prod.tulus']);

