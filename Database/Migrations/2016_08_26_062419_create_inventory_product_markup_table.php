<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductMarkupTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_product_markup', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->float('markup', 10, 2);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('inventory_product_markup');
    }

}
