<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSpacesStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_spaces_students', function (Blueprint $table) {
            $table->bigIncrements('row_id');
            $table->integer('sheet_number');
            $table->unsignedBigInteger('student_id');
            $table->unsignedInteger('space_id');
            $table->string('exam_id')->nullable();
            $table->unsignedBigInteger('academic_timetable_information_id');
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
            $table->unsignedInteger("deleted_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('exam_spaces_students', function (Blueprint $table) {
            $table->foreign("academic_timetable_information_id")->references("academic_timetable_information_id")->on("academic_timetable_information");
            $table->foreign("student_id")->references("student_id")->on("students");
            $table->foreign("space_id")->references("id")->on("spaces_assign");
            $table->foreign("created_by")->references("admin_id")->on("admins");
            $table->foreign("updated_by")->references("admin_id")->on("admins");
            $table->foreign("deleted_by")->references("admin_id")->on("admins");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_spaces_students');
    }
}
