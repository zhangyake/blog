<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    public $fillable = ['status', 'info', 'infocode', 'province', 'city', 'adcode', 'rectangle'];

}
