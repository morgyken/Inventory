<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreProducts extends Migration
{
    /*
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventory_store_products', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('store_id');

            $table->unsignedInteger('product_id');

            $table->integer('quantity');

            $table->decimal('selling_price');

            $table->decimal('insurance_price');

            $table->timestamps();

        });
    }

    /*
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('inventory_store_products');
    }
}
