<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterGlAccountInFinanceInvoice extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('finance_invoices', function ($table) {
            $table->dropForeign(['gl_account']);
            $table->dropColumn('gl_account');
        });

        Schema::table('finance_invoices', function ($table) {
            $table->integer('gl_account')->unsigned()->after('creditor')->nullable();
            $table->foreign('gl_account')->references('id')->on('finance_gl_accounts');
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
