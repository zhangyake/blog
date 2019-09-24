<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Like.
 *
 * @property int                                           $id
 * @property int                                           $user_id     点赞用户
 * @property string                                        $target_type
 * @property int                                           $target_id
 * @property \Illuminate\Support\Carbon|null               $created_at
 * @property \Illuminate\Support\Carbon|null               $updated_at
 * @property \Illuminate\Database\Eloquent\Model|\Eloquent $target
 * @property \App\Models\User                              $user
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereTargetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereTargetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like withoutTrashed()
 * @mixin \Eloquent
 */
class Like extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    protected $table = 'likes';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function target()
    {
        return $this->morphTo('target');
    }
}
