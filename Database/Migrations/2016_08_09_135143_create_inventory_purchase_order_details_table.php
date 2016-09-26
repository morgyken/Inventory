<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPurchaseOrderDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_purchase_order_details', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('order')->unsigned();
            $table->integer('product')->unsigned();
            $table->integer('quantity')->default(1);
            $table->float('price', 10, 2);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product')->references('id')->on('inventory_products')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('order')->references('id')->on('inventory_purchase_orders')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('inventory_purchase_order_details');
    }

}
