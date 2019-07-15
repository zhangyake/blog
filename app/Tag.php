<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Tag
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Article[] $articles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Tag query()
 * @mixin \Eloquent
 */
class Tag extends Model
{
    public    $timestamps = false;
    protected $fillable   = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'tag_articles', 'tag_id', 'article_id');
    }

}
