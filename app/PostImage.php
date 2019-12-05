<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PostImage extends Eloquent
{
    // Specify the fillable fields
    protected $fillable = ['post_id', 'post_image_path', 'post_image_caption'];

    // post_images can belong to only 1 post
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
