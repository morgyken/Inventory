<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollabmedOrderQuotationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('collabmed_order_quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier')->unsigned();
            $table->integer('order')->unsigned();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('supplier')
                    ->references('id')
                    ->on('inventory_suppliers')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');

            $table->foreign('order')
                    ->references('id')
                    ->on('inventory_orders_collabmed')
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
        Schema::dropIfExists('collabmed_order_quotations');
    }

}
