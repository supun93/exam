<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class Coursemodules extends Model
{
    protected $fillable = [];
    protected $table = 'course_modules';
    protected $primaryKey = 'module_id';

    public function course()
    { 
        return $this->hasOne(Course::class,'course_id','course_id');
    }
}
