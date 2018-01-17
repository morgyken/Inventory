<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreOrdersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_store_orders', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('ordered_by')->unsigned();
            $table->integer('dispatching_store')->unsigned();
            $table->integer('requesting_store')->unsigned();
            $table->date('delivery_date')->nullable();
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inventory_store_orders');
    }

}
