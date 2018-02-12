<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCancelledColumnsToInventoryStoreOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventory_store_orders', function(Blueprint $table) {

            $table->boolean('cancelled')->default(false);

            $table->integer('cancelled_by')->nullable();

            $table->longText('cancellation_reason')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            $table->dropColumn('cancelled');

            $table->dropColumn('cancelled_by');

            $table->dropColumn('cancellation_reason');
        });
    }
}
