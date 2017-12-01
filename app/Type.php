<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public function articles(){
        return $this->hasMany(Article::class,'type_id','id')->select(['id','title','created_at','is_show','user_id','type_id']);
    }


}
