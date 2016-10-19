<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InventoryInvoicePayments extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('finance_invoice_payments', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('account')->unsigned()->nullable();
            $table->integer('user')->unsigned()->nullable();
            $table->string('mode');
            $table->decimal('amount', 10, 2);
            $table->integer('grn')->unsigned()->nullable();
            $table->integer('invoice')->unsigned()->nullable();
            $table->timestamps();
            /*  $table->foreign('account')->references('id')->on('finance_bank_accounts')
              ->onDelete('cascade')
              ->onUpdate('cascade'); */
            $table->foreign('user')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            $table->foreign('grn')->references('id')->on('inventory_batches')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            /*   $table->foreign('invoice')->references('id')->on('finance_invoices')
              ->onDelete('cascade')
              ->onUpdate('cascade'); */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('finance_invoice_payments');
    }

}
