<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryCategoriesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent')->unsigned()->nullable();
            $table->float('cash_markup')->nullable();
            $table->float('credit_markup')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('inventory_categories');
    }

}
