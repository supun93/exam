<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [];
    protected $table = 'faculties';
    protected $primaryKey = 'faculty_id';
}
