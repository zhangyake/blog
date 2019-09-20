<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = ['id'];

    public function children(){
        return $this->hasMany(Area::class,'parent_id','id');
    }
    public $timestamps = false;
}