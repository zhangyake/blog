<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function target()
    {
        return $this->morphTo('target');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'target');
    }

    public function replys()
    {
        return $this->morphMany(Reply::class, 'target');
    }
}
