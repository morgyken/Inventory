<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationSensitivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_sensitivity', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visit_id')->unsigned();
            $table->integer('drug_id')->unsigned();
            $table->integer('test_id')->unsigned()->nullable();
            $table->string('sensitivity');
            $table->timestamps();

            $table->foreign('visit_id')
                ->references('id')
                ->on('evaluation_visits')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('drug_id')
                ->references('id')
                ->on('inventory_products')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('test_id')
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
    public function down()
    {
        Schema::dropIfExists('evaluation_sensitivity');
    }
}
