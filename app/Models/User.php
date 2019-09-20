<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $table = 'users';
    protected $fillable = ['username', 'password'];


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
