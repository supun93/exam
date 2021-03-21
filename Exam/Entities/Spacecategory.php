<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Admin\Observers\AdminActivityObserver; 

class spacecategory extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'space_category';

    
}
