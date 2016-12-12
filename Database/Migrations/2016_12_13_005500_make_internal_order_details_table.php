<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeInternalOrderDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('internal_order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('internal_order')->unsigned();
            $table->integer('item')->unsigned();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('internal_order')
                    ->references('id')
                    ->on('internal_order')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('item')
                    ->references('id')
                    ->on('inventory_products')
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
        Schema::dropIfExists('internal_order_details');
    }

}
