<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryDispensingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_dispensing', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('batch')->unsigned();
            $table->integer('product')->unsigned();
            $table->decimal('price', 10, 2);
            $table->float('discount')->default(0);
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('product')->references('id')->on('inventory_products')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('batch')->references('id')->on('inventory_batch_sales')
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
        Schema::drop('inventory_dispensing');
    }

}
