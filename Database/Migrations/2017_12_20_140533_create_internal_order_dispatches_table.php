<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternalOrderDispatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_internal_order_dispatches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->integer('qty_dispatched');
            $table->integer('qty_accepted')->nullable();
            $table->integer('qty_rejected')->nullable();
            $table->unsignedInteger('batch_id')->nullable();
            $table->text('reject_reason')->nullable();
            $table->unsignedInteger('dispatch_user');
            $table->unsignedInteger('receive_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_internal_order_dispatches');
    }
}
