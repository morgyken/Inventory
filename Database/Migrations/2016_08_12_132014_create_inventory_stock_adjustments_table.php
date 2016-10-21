<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryStockAdjustmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_stock_adjustments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('product')->unsigned();
            $table->integer('opening_qty')->default(0);
            $table->integer('quantity');
            $table->integer('new_stock')->default(0);
            $table->enum('method', ['+', '-'])->default('+');
            $table->enum('type', ['manual', 'sales', 'purchase']);
            $table->longText('reason');
            $table->enum('approved', ['yes', 'no'])->nullable();
            $table->integer('user')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('product')->references('id')->on('inventory_products')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('user')->references('id')->on('users')
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
        Schema::dropIfExists('inventory_stock_adjustments');
    }

}
