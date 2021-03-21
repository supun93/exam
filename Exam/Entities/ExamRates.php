<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class ExamRates extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'exam_rates';
    protected $primaryKey = 'exam_rate_id';
}
