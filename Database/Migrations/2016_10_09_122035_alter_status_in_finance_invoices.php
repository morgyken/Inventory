<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusInFinanceInvoices extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('finance_invoices', function ($table) {
            $table->dropColumn('status');
        });
        Schema::table('finance_invoices', function ($table) {
            $table->string('status')->nullable()->after('amount');
        });

        Schema::table('inventory_batches', function ($table) {
            $table->integer('payment_status')->unsigned()->nullable()->change();
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
