<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryBatchSalesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_batch_sales', function(Blueprint $table) {
            $table->increments('id');
            $table->string('receipt')->unique();
            $table->string('payment_mode');
            $table->boolean('paid')->default(false);
            $table->integer('user')->unsigned();
            $table->integer('customer')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user')->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('customer')->references('id')->on('customers')
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
        Schema::drop('inventory_batch_sales');
    }

}
