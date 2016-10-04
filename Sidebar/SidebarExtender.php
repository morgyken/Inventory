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

namespace Ignite\Inventory\Sidebar;

use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Group;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender {

    public function extendWith(Menu $menu) {
        $menu->group('Dashboard', function (Group $group) {
            $group->item('Point of Sale', function (Item $item) {
                $item->icon('fa fa-cart-arrow-down');
                $item->route('inventory.shopfront');
            });
            $group->item('Finance', function (Item $item) {
                $item->item('Payments Overview', function (Item $item) {
                    $item->icon('fa fa fa-files-o');
                    $item->route('inventory.sales.receipts');
                });
            });
            $group->item('Inventory', function (Item $item) {
                $item->weight(3);
                $item->icon('fa fa-barcode');

                $item->item('Products', function (Item $item) {
                    $item->icon('fa fa-briefcase');

                    $item->item('Product Categories', function (Item $item) {
                        $item->icon('fa fa-sitemap');
                        $item->route('inventory.product_categories');
                    });
                    $item->item('Add Product', function(Item $item) {
                        $item->route('inventory.add_product');
                        $item->icon('fa fa-plus-circle');
                    });
                    $item->item('View Products', function (Item $item) {
                        $item->icon('fa fa-briefcase');
                        $item->route('inventory.products');
                    });
                    $item->item('Items in store', function (Item $item) {
                        $item->icon('fa fa-level-up');
                        $item->route('inventory.view_stock');
                    });
                    $item->item('Stock Adjustments', function (Item $item) {
                        $item->icon('fa fa-pencil-square');
                        $item->route('inventory.stock.adjustments');
                    });
                    $item->item('Adjust Product Price', function (Item $item) {
                        $item->icon('fa fa-euro');
                        $item->route('inventory.product.price');
                    });
                    /* $item->item('Set Markup Percentage', function (Item $item) {
                      $item->icon('fa fa-chevron-circle-up');
                      $item->route('inventory.product.markup');
                      }); */

                    $item->item('Set Product Discount', function (Item $item) {
                        $item->icon('fa fa-tag');
                        $item->route('inventory.product.discount');
                    });
                    /*
                      $item->item('Set Category Price', function (Item $item) {
                      $item->icon('fa fa-yen');
                      $item->route('inventory.category.price');
                      });
                     */
                    $item->item('Tax Categories', function (Item $item) {
                        $item->icon('fa fa-percent');
                        $item->route('inventory.tax_categories');
                    });
                    $item->item('Units of Measure', function (Item $item) {
                        $item->icon('fa fa-tint');
                        $item->route('inventory.units_of_measurement');
                    });
                });
                $item->item('Purchases', function(Item $item) {
                    $item->icon('fa fa-euro');
                    $item->item('Create LPO', function (Item $item) {
                        $item->icon('fa fa-hand-pointer-o');
                        $item->route('inventory.new_lpo');
                    });
                    $item->item('View LPOs', function (Item $item) {
                        $item->icon('fa fa-th');
                        $item->route('inventory.purchase_orders');
                    });
                    /*
                      $item->item('Internal Orders', function (Item $item) {
                      $item->icon('fa fa-dot-circle-o');
                      $item->route('inventory.orders.internal');
                      }); */
                    $item->item('Receive Goods', function (Item $item) {
                        $item->icon('fa fa-shopping-basket');
                        $item->route('inventory.receive_goods');
                    });
                    $item->item('View GRNS', function (Item $item) {
                        $item->icon('fa fa-list-alt');
                        $item->route('inventory.grns');
                    });

                    $item->item('Payment terms', function (Item $item) {
                        $item->icon('fa fa-square-o');
                        $item->route('inventory.payment_terms');
                    });
                });

                $item->item('Sales', function(Item $item) {
                    $item->icon('fa fa-money');
                    $item->item('Point of Sale', function (Item $item) {
                        $item->icon('fa fa-cart-arrow-down');
                        $item->route('inventory.shopfront');
                    });
                    $item->item('Sales Return', function (Item $item) {
                        $item->icon('fa fa-hand-lizard-o');
                        $item->route('inventory.sales.return');
                    });
                });

                $item->item('Reports', function(Item $item) {
                    $item->icon('fa fa-bars');

                    $item->item('Sales', function (Item $item) {
                        $item->icon('fa fa-cart-arrow-down');
                        $item->route('inventory.reports.sales');
                    }); //Sales

                    $item->item('Stock Report', function (Item $item) {
                        $item->icon('fa fa-hourglass-half');
                        $item->route('inventory.reports.stocks');
                    }); //stock Reports
                });

                $item->item('Suppliers', function(Item $item) {
                    $item->icon('fa fa-tty');
                    $item->item('Add Supplier', function (Item $item) {
                        $item->icon('fa fa-plus');
                        $item->route('inventory.manage_suppliers');
                    });
                    $item->item('View Suppliers', function (Item $item) {
                        $item->icon('fa fa-list');
                        $item->route('inventory.suppliers');
                    });
                    $item->item('Receive Invoice', function (Item $item) {
                        $item->icon('fa fa-file-text-o');
                        $item->route('inventory.suppliers.invoice');
                    });
                });
            });
        });
        return $menu;
    }

}
