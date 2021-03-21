<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvigilatorForExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_invigilators', function (Blueprint $table) {
            $table->bigIncrements('row_id');
            $table->integer('invigilator_id');
            $table->unsignedBigInteger('academic_timetable_information_id');
            $table->integer('from_table_name');
            $table->integer('status')->default(1);
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
            $table->unsignedInteger("deleted_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('exam_invigilators', function (Blueprint $table) {
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
        Schema::dropIfExists('invigilator_for_exams');
    }
}
