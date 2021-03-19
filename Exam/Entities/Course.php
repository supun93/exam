<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [];
    protected $table = 'courses';
    protected $primaryKey = 'course_id';

    public function batches()
    {
        return $this->hasMany(Batch::class, 'course_id','course_id')->whereDeletedAt(null);
    }
}
