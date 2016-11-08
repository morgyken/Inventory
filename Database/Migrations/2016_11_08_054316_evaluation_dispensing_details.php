<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EvaluationDispensingDetails extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_dispensing_details', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('batch')->unsigned();
            $table->integer('product')->unsigned();
            $table->integer('quantity')->default(1);
            $table->float('price', 10, 2);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('product')->references('id')->on('inventory_products')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('batch')->references('id')->on('inventory_evaluation_dispensing')
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
        Schema::dropIfExists('evaluation_dispensing_details');
    }

}
