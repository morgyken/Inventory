<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InventoryInsuranceDetails extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_insurance_details', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('customer')->unsigned();
            $table->integer('insurance_company')->unsigned();
            $table->integer('credit_scheme')->unsigned();
            $table->string('policy_no');
            $table->string('principal');
            $table->date('date_of_birth');
            $table->string('relation');
            $table->timestamps();

            $table->foreign('customer')->references('id')->on('inventory_customers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('insurance_company')->references('id')->on('settings_insurance')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('credit_scheme')->references('id')->on('settings_schemes')
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
        Schema::drop('inventory_insurance_details');
    }

}
