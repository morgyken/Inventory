<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_products', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('category')->unsigned();
            $table->integer('unit')->unsigned();
            $table->integer('tax_category')->unsigned()->nullable();
            $table->string('strength')->nullable();
            $table->string('label_type')->nullable();
            $table->string('formulation')->nullable();
            $table->timestamps();

            $table->foreign('category')->references('id')
                    ->on('inventory_categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('unit')->references('id')
                    ->on('inventory_units')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('tax_category')->references('id')
                    ->on('inventory_tax_categories')
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
        Schema::drop('inventory_products');
    }

}
