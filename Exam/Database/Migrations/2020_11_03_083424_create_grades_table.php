<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_grades', function (Blueprint $table) {
            $table->bigIncrements('grade_id');
            $table->string('grade_name', 100);
            $table->string('gpa');
            $table->integer('start');
            $table->integer('end');
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedBigInteger("grade_group_id")->nullable();
            $table->softDeletes();
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
            $table->unsignedInteger("deleted_by")->nullable();
            $table->timestamps();
        });
        Schema::table('exam_grades', function (Blueprint $table) {
            $table->foreign("grade_group_id")->references("grade_group_id")->on("exam_grade_groupes");
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
        Schema::dropIfExists('exam_grades');
    }
}
