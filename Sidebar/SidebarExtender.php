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

use Ignite\Core\Contracts\Authentication;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Group;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender {

    protected $auth;

    public function __construct(Authentication $auth) {
        $this->auth = $auth;
    }

    public function extendWith(Menu $menu) {
        $menu->group('Dashboard', function (Group $group) {

            $group->item('Point of Sale', function (Item $item) {
                $item->icon('fa fa-cart-arrow-down');
                $item->route('inventory.shopfront');
                $item->authorize($this->auth->hasAccess('inv.*'));
            });


            $group->item('Inventory', function (Item $item) {
                $item->weight(3);
                $item->icon('fa fa-barcode');
                $item->authorize($this->auth->hasAccess('inv.main_menu'));

                $item->item('Products', function (Item $item) {
                    $item->icon('fa fa-briefcase');
                    $item->authorize($this->auth->hasAccess('inv.prod'));
                    $item->item('Product Categories', function (Item $item) {
                        $item->icon('fa fa-sitemap');
                        $item->route('inventory.product_cat');
                        $item->authorize($this->auth->hasAccess('inv.cats'));
                    });
                    $item->item('Add Product', function(Item $item) {
                        $item->route('inventory.add_product');
                        $item->icon('fa fa-plus-circle');
                        $item->authorize($this->auth->hasAccess('inv.prod'));
                    });
                    $item->item('View Products', function (Item $item) {
                        $item->icon('fa fa-briefcase');
                        $item->route('inventory.products');
                        $item->authorize($this->auth->hasAccess('inv.prod'));
                    });
                    $item->item('Items in Store', function (Item $item) {
                        $item->icon('fa fa-level-up');
                        $item->route('inventory.view_stock');
                        $item->authorize($this->auth->hasAccess('inv.prod'));
                    });
                    $item->item('Stock Adjustments', function (Item $item) {
                        $item->icon('fa fa-pencil-square');
                        $item->route('inventory.stock.adjustments');
                        $item->authorize($this->auth->hasAccess('inv.prod'));
                    });
                    $item->item('Adjust Product Price', function (Item $item) {
                        $item->icon('fa fa-euro');
                        $item->route('inventory.product.price');
                        $item->authorize($this->auth->hasAccess('inv.prod'));
                    });
                    /* $item->item('Set Markup Percentage', function (Item $item) {
                      $item->icon('fa fa-chevron-circle-up');
                      $item->route('inventory.product.markup');
                      }); */

                    $item->item('Set Product Discount', function (Item $item) {
                        $item->icon('fa fa-tag');
                        $item->route('inventory.product.discount');
                        $item->authorize($this->auth->hasAccess('inv.prod'));
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
                        $item->authorize($this->auth->hasAccess('inv.prod'));
                    });
                    $item->item('Units of Measure', function (Item $item) {
                        $item->icon('fa fa-tint');
                        $item->route('inventory.units_of_measurement');
                        $item->authorize($this->auth->hasAccess('inv.prod'));
                    });
                });
                $item->item('Purchases', function(Item $item) {
                    $item->icon('fa fa-euro');
                    $item->authorize($this->auth->hasAccess('inv.purchases'));

                    $item->item('Requisitions', function (Item $item) {
                        $item->icon('fa fa-registered');
                        $item->item('Make Requisition', function (Item $item) {
                            $item->icon('fa fa-bell');
                            $item->route('inventory.requisition');
                            $item->authorize($this->auth->hasAccess('inv.purchases'));
                        });
                        $item->item('View Requisitions', function (Item $item) {
                            $item->icon('fa fa-list');
                            $item->route('inventory.requisitions.all');
                            $item->authorize($this->auth->hasAccess('inv.purchases'));
                        });
                        $item->authorize($this->auth->hasAccess('inv.purchases'));
                    });


                    $item->item('Create LPO', function (Item $item) {
                        $item->icon('fa fa-hand-pointer-o');
                        $item->route('inventory.new_lpo');
                        $item->authorize($this->auth->hasAccess('inv.purchases'));
                    });
                    $item->item('View LPOs', function (Item $item) {
                        $item->icon('fa fa-th');
                        $item->route('inventory.purchase_orders');
                        $item->authorize($this->auth->hasAccess('inv.purchases'));
                    });
                    /*
                      $item->item('Internal Orders', function (Item $item) {
                      $item->icon('fa fa-dot-circle-o');
                      $item->route('inventory.orders.internal');
                      }); */
                    $item->item('Receive Goods', function (Item $item) {
                        $item->icon('fa fa-shopping-basket');
                        $item->route('inventory.receive_goods');
                        $item->authorize($this->auth->hasAccess('inv.purchases'));
                    });
                    $item->item('View GRNS', function (Item $item) {
                        $item->icon('fa fa-list-alt');
                        $item->route('inventory.grns');
                        $item->authorize($this->auth->hasAccess('inv.purchases'));
                    });

                    $item->item('Payment Terms', function (Item $item) {
                        $item->icon('fa fa-square-o');
                        $item->route('inventory.payment_terms');
                        $item->authorize($this->auth->hasAccess('inv.purchases'));
                    });
                });

                $item->item('Internal Orders', function(Item $item) {
                    $item->icon('fa fa-list');
                    $item->authorize($this->auth->hasAccess('inv.internal_orders'));
                    $item->item('Stores', function (Item $item) {
                        $item->icon('fa fa-building');
                        $item->route('inventory.stores');
                        $item->authorize($this->auth->hasAccess('inv.internal_orders'));
                    });

                    $item->item('Internal Orders', function (Item $item) {
                        $item->icon('fa fa-arrows');
                        $item->route('inventory.orders.internal');
                        $item->authorize($this->auth->hasAccess('inv.internal_orders'));
                    });
                });

                $item->item('Sales', function(Item $item) {
                    $item->icon('fa fa-money');
                    $item->authorize($this->auth->hasAccess('inv.sales'));
                    $item->item('Point of Sale', function (Item $item) {
                        $item->icon('fa fa-cart-arrow-down');
                        $item->route('inventory.shopfront');
                        //$item->authorize($this->auth->hasAccess('inventory.Sales.Point of Sale'));
                    });
                    $item->item('Sales Return', function (Item $item) {
                        $item->icon('fa fa-hand-lizard-o');
                        $item->route('inventory.sales.return');
                        //$item->authorize($this->auth->hasAccess('inventory.Sales.Sales Return'));
                    });
                });

                $item->item('Reports', function(Item $item) {
                    $item->icon('fa fa-bars');
                    $item->authorize($this->auth->hasAccess('inv.reports'));
                    $item->item('Sales', function (Item $item) {
                        $item->icon('fa fa-cart-arrow-down');
                        $item->route('inventory.reports.sales');
                        // $item->authorize($this->auth->hasAccess('inventory.Reports.View Sales Reports'));
                    }); //Sales

                    $item->item('Product Sales', function (Item $item) {
                        $item->icon('fa fa-gift');
                        $item->route('inventory.reports.sales.product');
                        //$item->authorize($this->auth->hasAccess('inventory.Reports.View Product Sales Report'));
                    }); //Sales

                    $item->item('Stock Report', function (Item $item) {
                        $item->icon('fa fa-hourglass-half');
                        $item->route('inventory.reports.stocks');
                        // $item->authorize($this->auth->hasAccess('inventory.Reports.View Stock Report'));
                    }); //stock Reports

                    $item->item('Stock Movement', function (Item $item) {
                        $item->icon('fa fa-arrows');
                        $item->route('inventory.reports.stocks.movement');
                        //$item->authorize($this->auth->hasAccess('inventory.Reports.View Stock Movement Report'));
                    }); //stock Reports


                    $item->item('Item Expiry', function (Item $item) {
                        $item->icon('fa fa-calendar');
                        $item->route('inventory.reports.stocks.expiry');
                        // $item->authorize($this->auth->hasAccess('inventory.Reports.View Item Expiry Report'));
                    }); //stock Reports
                });

                $item->item('Suppliers', function(Item $item) {
                    $item->icon('fa fa-tty');
                    $item->authorize($this->auth->hasAccess('inv.sales'));
                    $item->item('Add Supplier', function (Item $item) {
                        $item->icon('fa fa-plus');
                        $item->route('inventory.manage_suppliers');
                        //$item->authorize($this->auth->hasAccess('inventory.Suppliers.Add Supplier'));
                    });
                    $item->item('View Suppliers', function (Item $item) {
                        $item->icon('fa fa-list');
                        $item->route('inventory.suppliers');
                        //$item->authorize($this->auth->hasAccess('inventory.Suppliers.View Suppliers'));
                    });
                    $item->item('Receive Invoice', function (Item $item) {
                        $item->icon('fa fa-file-text-o');
                        $item->route('inventory.suppliers.invoice');
                        // $item->authorize($this->auth->hasAccess('inventory.Suppliers.Receive Invoice'));
                    });
                });

                $item->item('Clients', function(Item $item) {
                    $item->icon('fa fa-user');
                    //$item->authorize($this->auth->hasAccess('inventory.Clients.Manage Clients'));
                    $item->item('New Insurance Client', function (Item $item) {
                        $item->icon('fa fa-users');
                        $item->route('inventory.clients.credit', 'null');
                    }); //Sales

                    $item->item('Manage Clients', function (Item $item) {
                        $item->icon('fa fa-pencil-square');
                        $item->route('inventory.clients.all', 'null');
                    });
                });
            });
        });
        return $menu;
    }

}
