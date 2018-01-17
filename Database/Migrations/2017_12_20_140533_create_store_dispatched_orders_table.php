<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreDispatchedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_store_dispatched_orders', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('order_detail_id');

            $table->unsignedInteger('batch_id')->nullable();

            $table->integer('dispatched');

            $table->unsignedInteger('dispatched_by');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_store_dispatched_orders');
    }
}
