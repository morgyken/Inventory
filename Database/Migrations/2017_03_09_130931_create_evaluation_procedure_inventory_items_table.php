<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationProcedureInventoryItemsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('evaluation_procedure_inventory_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procedure')->unsigned();
            $table->integer('item')->unsigned();
            $table->float('units')->nullable();
            $table->timestamps();

            $table->foreign('item')
                    ->references('id')
                    ->on('inventory_products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('procedure')
                    ->references('id')
                    ->on('evaluation_procedures')
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
        Schema::dropIfExists('evaluation_procedure_inventory_items');
    }

}
