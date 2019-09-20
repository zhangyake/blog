<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'replys';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function target()
    {
        return $this->morphTo('target');
    }

    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'target');
    }
}