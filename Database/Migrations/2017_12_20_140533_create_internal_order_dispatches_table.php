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

            $table->unsignedInteger('order_detail_id');

            $table->unsignedInteger('batch_id')->nullable();

            $table->integer('dispatched');

            $table->integer('accepted')->nullable();

            $table->integer('rejected')->nullable();

            $table->text('reject_reason')->nullable();

            $table->unsignedInteger('dispatched_by');

            $table->unsignedInteger('received_by')->nullable();

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
