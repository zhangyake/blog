<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
/**
 * App\Article
 *
 * @property-read \App\Category $category
 * @property-read mixed $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tag[] $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Article query()
 * @mixin \Eloquent
 */
class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'content_md',
        'summary',
        'user_id',
        'category_id',
        'state'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_articles', 'article_id', 'tag_id');
    }
}
