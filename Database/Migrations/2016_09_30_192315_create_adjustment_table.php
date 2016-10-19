<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustmentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('inventory_stock_adjustments', function (Blueprint $table) {
            $table->integer('new_stock')->default(0)->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('inventory_stock_adjustments', function (Blueprint $table) {
            $table->dropColumn('new_stock');
        });
    }

}
