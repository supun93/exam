<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class AcademicTimeTableInformation extends Model
{
    protected $fillable = [];
    protected $table = 'academic_timetable_information';
    protected $primaryKey = 'academic_timetable_information_id';

    public function subgroupesForTimetable()
    { 
        return $this->hasMany(AcademicTimeTableSubgroupes::class,'academic_timetable_information_id','academic_timetable_information_id');
    }
    public function moduleName()
    { 
        return $this->hasOne(Coursemodules::class,'module_id','module_id');
    }
    public function examCategory()
    { 
        return $this->hasOne(Examcategory::class,'exam_category_id','exam_category_id');
    }
}
