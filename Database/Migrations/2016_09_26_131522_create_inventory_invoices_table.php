<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryInvoicesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('inventory_finance_invoices', function(Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->integer('creditor')->unsigned();
            $table->integer('gl_account')->unsigned()->nullable();
            $table->integer('grn')->unsigned()->nullable();
            $table->float('amount', 10, 2);
            $table->date('date');
            $table->date('due_date');
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('creditor')->references('id')->on('inventory_suppliers')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('grn')->references('id')->on('inventory_batches');
            /* $table->foreign('gl_account')->references('id')->on('finance_gl_accounts')
              ->onUpdate('cascade')
              ->onDelete('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('inventory_finance_invoices');
    }

}
