<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamgroupesbatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_group_batches', function (Blueprint $table) {
            $table->bigIncrements('row_id');
            $table->unsignedBigInteger('exam_group_id');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedTinyInteger('status')->nullable();
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
            $table->unsignedInteger("deleted_by")->nullable();
            $table->softDeletes();
            $table->timestamps();
        }); 
        Schema::table('exam_group_batches', function (Blueprint $table) {
            $table->foreign("exam_group_id")->references("exam_group_id")->on("exam_groupes");
            $table->foreign("batch_id")->references("batch_id")->on("batches");
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
        Schema::dropIfExists('exam_group_batches');
    }
}
