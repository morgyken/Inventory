<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreStockAdjustments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_store_stock_adjustments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('store_product_id');

            $table->unsignedInteger('previous_quantity');

            $table->unsignedInteger('new_quantity');

            $table->unsignedInteger('reason');

            $table->unsignedInteger('user_id');

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
        Schema::dropIfExists('');
    }
}
