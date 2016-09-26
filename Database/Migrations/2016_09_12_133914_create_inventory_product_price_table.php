<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductPriceTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_product_price', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->integer('batch')->unsigned()->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('selling', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('product')->references('id')->on('inventory_products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('batch')->references('id')->on('inventory_batches')
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
        Schema::drop('inventory_product_price');
    }

}
