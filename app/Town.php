<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    public $timestamps = false;
    public static function getIdBySlug($slug)
    {
        return static::select()->where('slug', '=', $slug)->first();
    }
}
