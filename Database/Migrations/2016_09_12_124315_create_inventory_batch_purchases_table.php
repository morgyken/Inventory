<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryBatchPurchasesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_batch_purchases', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('batch')->unsigned();
            $table->integer('product')->unsigned();
            $table->integer('quantity');
            $table->integer('qty_sold')->nullable();
            $table->boolean('active')->default(false);
            $table->integer('bonus')->default(0);
            $table->float('discount', 10, 2);
            $table->decimal('unit_cost', 10, 2);
            $table->date('expiry_date')->nullable();
            $table->integer('package_size')->default(1);
            $table->timestamps();

            $table->foreign('batch')->references('id')->on('inventory_batches')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('product')->references('id')->on('inventory_products')
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
        Schema::drop('inventory_batch_purchases');
    }

}
