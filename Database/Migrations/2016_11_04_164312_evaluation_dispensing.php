<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EvaluationDispensing extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_evaluation_dispensing', function(Blueprint $column) {
            $column->increments('id');
            $column->integer('visit')->unsigned();
            $column->integer('user')->unsigned()->nullable();
            $column->boolean('payment_status')->default(0)->nullable();
            $column->timestamps();

            $column->foreign('user')
                    ->references('id')->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $column->foreign('visit')
                    ->references('id')->on('evaluation_visits')
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
        Schema::drop('evaluation_dispensing');
    }

}
