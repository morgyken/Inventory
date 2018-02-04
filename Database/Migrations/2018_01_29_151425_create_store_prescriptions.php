<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorePrescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_store_prescriptions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('product_id');

            $table->unsignedInteger('store_id');

            $table->unsignedInteger('prescription_id');

            $table->unsignedInteger('quantity');

            $table->unsignedInteger('dispensed');

            $table->string('facility')->default('outpatient');

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
        Schema::dropIfExists('inventory_store_prescriptions');
    }
}
