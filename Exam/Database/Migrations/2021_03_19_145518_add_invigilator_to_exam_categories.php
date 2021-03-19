<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInvigilatorToExamCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exam_categories', function (Blueprint $table) {
            $table->integer("student_count")->nullable()->after('category_status');
            $table->integer("invigilator_ratio")->nullable()->after('student_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_categories', function (Blueprint $table) {

        });
    }
}
