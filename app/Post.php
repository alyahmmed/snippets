<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function images()
    {
      return $this->hasMany('App\PostImage');
    }
}
