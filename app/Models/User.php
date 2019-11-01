<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User.
 *
 * @property int                                                                                                       $id
 * @property string                                                                                                    $username
 * @property string                                                                                                    $password
 * @property string                                                                                                    $wechat_openid       微信openId
 * @property string|null                                                                                               $nickname            昵称
 * @property string|null                                                                                               $avatar              微信头像url
 * @property string|null                                                                                               $gender              性别
 * @property int                                                                                                       $is_frozen           是否冻结
 * @property string|null                                                                                               $last_login          最后一次登录时间
 * @property \Illuminate\Support\Carbon|null                                                                           $created_at
 * @property \Illuminate\Support\Carbon|null                                                                           $updated_at
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Article[]                                            $articles
 * @property int|null                                                                                                  $articles_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[]                                            $comments
 * @property int|null                                                                                                  $comments_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Favorite[]                                           $favorites
 * @property int|null                                                                                                  $favorites_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Like[]                                               $likes
 * @property int|null                                                                                                  $likes_count
 * @property \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property int|null                                                                                                  $notifications_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[]                                              $replys
 * @property int|null                                                                                                  $replys_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIsFrozen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereWechatOpenid($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'users';
    protected $fillable = ['username','password','github_user_id','nickname','email','avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function replys()
    {
        return $this->hasMany(Reply::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
