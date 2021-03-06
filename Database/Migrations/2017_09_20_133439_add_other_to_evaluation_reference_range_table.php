<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherToEvaluationReferenceRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try{
             Schema::table('evaluation_reference_range', function (Blueprint $table) {
                $table->string('other_type')->after('flag')->nullable();
             });
        }catch (\Exception $e){

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_reference_range', function (Blueprint $table) {

        });
    }
}
