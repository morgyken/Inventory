<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollabmedOrderQuotationsDetailsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('collabmed_order_quotation_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quotation')->unsigned();
            $table->integer('item')->unsigned();
            $table->integer('units_required');
            $table->integer('units_to_supply')->nullable();
            $table->double('unit_price')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('quotation')
                    ->references('id')
                    ->on('collabmed_order_quotations')
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
        Schema::dropIfExists('collabmed_order_quotation_details');
    }

}
