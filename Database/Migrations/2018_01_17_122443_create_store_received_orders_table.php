<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreReceivedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_store_received_orders', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('order_detail_id')->nullable();

            $table->integer('received')->nullable();

            $table->integer('rejected')->nullable();

            $table->text('reason')->nullable();

            $table->unsignedInteger('received_by')->nullable();

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
        Schema::dropIfExists('inventory_store_received_orders');
    }
}
