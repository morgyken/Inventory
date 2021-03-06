<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlagToEvaluationReferenceRangeTable extends Migration
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
                    $table->string('flag')->nullable()->after('lg_value');
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
