<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryStocksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_stocks', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->integer('quantity');
            $table->timestamps();
            $table->foreign('product')->references('id')->on('inventory_products')
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
        Schema::drop('inventory_stocks');
    }

}
