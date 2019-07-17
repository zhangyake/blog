<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'page_image_url',
        'user_id',
        'category_id',
        'state'
    ];

     protected $appends = ['state_txt'];
     protected $states = [
         '待发布','已发布','已删除'
     ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_articles', 'article_id', 'tag_id');
    }

    public function getStateTxtAttribute($value)
    {
        return $this->states[$this->attributes['state']];
    }
    public function getPageImageUrlAttribute($value)
    {
        return Str::startsWith($value,['http:','https:']) ? $value : asset("storage/$value");
    }
}
