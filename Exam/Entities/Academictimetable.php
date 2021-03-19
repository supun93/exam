<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class Academictimetable extends Model
{
    protected $fillable = [];
    protected $table = 'academic_timetables';
    protected $primaryKey = 'academic_timetable_id';
}
