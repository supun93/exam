<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Observers\AdminActivityObserver;
class Examgroupes extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'exam_groupes';
    protected $primaryKey = 'exam_group_id';

    public static function boot() 
    {
        parent::boot();

        //Use this code block to track activities regarding this model
        //Use this code block in every model you need to record
        //This will record created_by, updated_by, deleted_by admins too, if you have set those fields in your model
        //self::observe(AdminActivityObserver::class);
    }
}
