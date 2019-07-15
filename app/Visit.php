<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Visit
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Visit query()
 * @mixin \Eloquent
 */
class Visit extends Model
{

    public $fillable = ['status', 'info', 'infocode', 'province', 'city', 'adcode', 'rectangle'];

}
