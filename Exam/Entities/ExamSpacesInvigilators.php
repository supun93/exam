<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Slo\Entities\Spaceassign as Spaces;
class ExamSpacesInvigilators extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'exam_spaces_invigilators';
    protected $primaryKey = 'row_id';

    public function spaces(){
        return $this->hasOne(Spaces::class, 'id','space_id');
    }
}
