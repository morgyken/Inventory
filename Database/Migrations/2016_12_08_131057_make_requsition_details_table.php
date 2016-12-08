<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeRequsitionDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('requisition_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requisition')->unsigned();
            $table->integer('item')->unsigned();
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('requisition')
                    ->references('id')
                    ->on('requisitions')
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
        Schema::dropIfExists('requisition_details');
    }

}
