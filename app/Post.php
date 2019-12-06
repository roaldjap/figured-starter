<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';

    protected $fillable = ['title', 'body', 'user_id'];

    // source: https://github.com/jenssegers/laravel-mongodb#relations
    public function author()
    {
        return $this->belongsTo('App\User');
    }

    public function post_images()
    {
        return $this->hasMany('App\PostImage');
    }
}
