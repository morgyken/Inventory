<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventorySalesReturnsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_sales_returns', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->string('receipt_no');
            $table->integer('quantity');
            $table->longText('reason');
            $table->boolean('stocked')->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('inventory_sales_returns');
    }

}
