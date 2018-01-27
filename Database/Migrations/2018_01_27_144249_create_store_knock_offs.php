<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreKnockOffs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_store_knock_offs', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('product_id');

            $table->unsignedInteger('knocked_by');

            $table->integer('quantity');

            $table->longText('reason');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_store_knock_offs');
    }
}
