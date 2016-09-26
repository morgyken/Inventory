<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryPurchaseOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_purchase_orders', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier')->unsigned();
            $table->integer('payment_terms')->unsigned();
            $table->integer('payment_mode');
            $table->date('deliver_date')->nullable();
            $table->smallInteger('status')->default(0);
            $table->integer('user')->unsigned();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('supplier')->references('id')->on('inventory_suppliers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('payment_terms')->references('id')->on('inventory_payment_terms')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('inventory_purchase_orders');
    }

}
