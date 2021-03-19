<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Examgroupsstudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_group_students', function (Blueprint $table) {
            $table->bigIncrements('row_id');
            $table->unsignedBigInteger('exam_group_id');
            $table->unsignedBigInteger('subgroup_id')->nullable();
            $table->unsignedBigInteger('academic_timetable_information_id');
            $table->integer('student_id');
            $table->integer('student_type')->default(0);
            $table->string('note')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
            $table->unsignedInteger("deleted_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        }); 
        Schema::table('exam_group_students', function (Blueprint $table) {
            $table->foreign("exam_group_id")->references("exam_group_id")->on("exam_groupes");
            $table->foreign("subgroup_id")->references("id")->on("subgroups");
            $table->foreign("academic_timetable_information_id")->references("academic_timetable_information_id")->on("academic_timetable_information");
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
        //
    }
}
