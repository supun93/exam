<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;

class spacename extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'space_categoryname';

    public function spacecategory(){
        return $this->hasOne(Spacecategory::class, 'id','category_id')->whereDeletedAt(null);
    }
    
}
