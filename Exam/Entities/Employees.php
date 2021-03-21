<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = [];
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    
}
