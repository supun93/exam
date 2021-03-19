<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class BatchStudent extends Model
{
    protected $fillable = [];
    protected $table = 'batch_student';

    public function student(){
        return $this->hasOne(Student::class, 'range_id','student_id');
    }
}
