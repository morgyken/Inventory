<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestigationInventoryItemsConsumedTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_investigation_items_consumed', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('investigation')->unsigned();
            $table->integer('item')->unsigned();
            $table->float('units_consumed');
            $table->float('amount')->nullable();
            $table->timestamps();

            $table->foreign('investigation')
                    ->references('id')
                    ->on('evaluation_investigations')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('item')
                    ->references('id')
                    ->on('inventory_products')
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
        Schema::dropIfExists('evaluation_investigation_items_consumed');
    }

}
