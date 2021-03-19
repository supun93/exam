<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTitmetableInformationIdToExamGroupes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_groupes', function (Blueprint $table) {
            $table->unsignedBigInteger("academic_timetable_information_id")->nullable()->after('status');
            $table->foreign("academic_timetable_information_id")->references("academic_timetable_information_id")->on("academic_timetable_information");
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_groupes', function (Blueprint $table) {

        });
    }
}
