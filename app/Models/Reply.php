<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reply.
 *
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property int|null                                                    $likes_count
 * @property \App\Models\Reply                                           $parent
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent               $target
 * @property \App\Models\User                                            $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reply query()
 * @mixin \Eloquent
 */
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
