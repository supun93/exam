<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Slo\Entities\Spaceassign as Spaces;
class ExamSpacesStudents extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'exam_spaces_students';
    protected $primaryKey = 'row_id';

    public function student(){
        return $this->hasOne(Student::class, 'student_id','student_id');
    }
    public function spaces(){
        return $this->hasOne(Spaces::class, 'id','space_id');
    }
}
