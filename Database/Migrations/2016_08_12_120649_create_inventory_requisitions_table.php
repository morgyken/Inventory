<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryRequisitionsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_requisitions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('req_no')->unique();
            $table->integer('product')->unsigned();
            $table->integer('quantity');
            $table->string('status');
            $table->integer('user')->unsigned();
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
        Schema::drop('inventory_requisitions');
    }

}
