<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryInsuranceDetails extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_insurance_payment_details', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('scheme')->unsigned();
            $column->string('policy_number');
            $column->string('principal');
            $column->date('dob');
            $column->smallInteger('relationship');
            $column->timestamps();

            $column->foreign('scheme')->references('id')->on('schemes')
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
        Schema::drop('inventory_insurance_payment_details');
    }

}
