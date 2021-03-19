<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class AcademicTimeTableSubgroupes extends Model
{
    protected $fillable = [];
    protected $table = 'academic_timetable_subgroups';
    protected $primaryKey = 'academic_timetable_subgroup_id';

    public function subgroup()
    { 
        return $this->hasOne(Subgroups::class,'id','subgroup_id');
    }

}
