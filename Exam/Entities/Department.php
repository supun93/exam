<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [];
    protected $table = 'departments';
    protected $primaryKey = 'dept_id';
}
