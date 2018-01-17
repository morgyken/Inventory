<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreOrderDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_store_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_order')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inventory_store_order_details');
    }

}
