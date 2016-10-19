<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGrnFinanceInvoices extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('finance_invoices', function ($table) {
            $table->integer('grn')->unsigned()->after('gl_account')->nullable();
            $table->foreign('grn')->references('id')->on('inventory_batches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }

}
