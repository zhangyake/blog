<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Article extends Model
{
    use SoftDeletes;
    protected $table = 'articles';
    protected $guarded = ['id'];


    // -------------- relations ------------------
    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'article_tags');
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'target');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'target');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'target');
    }
}