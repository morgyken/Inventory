<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryBatchesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_batches', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier')->unsigned()->nullable();
            $table->integer('amount');
            $table->integer('user')->unsigned();
            $table->integer('store')->unsigned()->nullable();
            $table->integer('order')->unsigned()->nullable();
            $table->integer('in_order')->unsigned()->nullable();
            $table->integer('payment_status')->unsigned()->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('supplier')->references('id')->on('inventory_suppliers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('order')->references('id')->on('inventory_purchase_orders')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('in_order')->references('id')->on('internal_orders')
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
        Schema::drop('inventory_batches');
    }

}
