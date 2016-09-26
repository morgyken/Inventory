<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InternalOrders extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('internal_orders', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('author')->unsigned();
            $table->integer('dispatching_store')->unsigned();
            $table->integer('requesting_store')->unsigned();
            $table->date('deliver_date')->nullable();
            $table->smallInteger('status')->default(0);
            $table->integer('quantity');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('dispatching_store')->references('id')->on('clinics')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('requesting_store')->references('id')->on('clinics')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('author')->references('id')->on('users')
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
        Schema::drop('internal_orders');
    }

}
