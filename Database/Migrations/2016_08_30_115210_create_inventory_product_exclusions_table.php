<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductExclusionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_product_exclusions', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->integer('scheme')->unsigned();

            $table->foreign('scheme')->references('id')->on('settings_schemes')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['product', 'scheme']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inventory_product_exclusions');
    }

}
