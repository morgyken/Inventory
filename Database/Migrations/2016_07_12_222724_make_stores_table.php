<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeStoresTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_stores', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->unique();

            $table->string('description')->nullable();

            $table->unsignedInteger('clinic')->nullable();

            $table->unsignedInteger('parent_store_id')->nullable();

            $table->boolean('main_store')->comment('can receive from a supplier')->default(0);

            $table->boolean('delivery_store')->comment('can edit product prices')->default(0);

            $table->timestamps();

            $table->foreign('clinic')->references('id')->on('settings_clinics')
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
        Schema::dropIfExists('inventory_stores');
    }

}
