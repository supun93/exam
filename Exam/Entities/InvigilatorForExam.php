<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class InvigilatorForExam extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'exam_invigilators';
    protected $primaryKey = 'row_id';
}
