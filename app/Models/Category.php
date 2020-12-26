<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    //has many post
    public function posts()
    {
    	return $this->morphedByMany(Post::class, 'categoryable');
    }

    //has many course
    public function courses()
    {
    	return $this->morphedByMany(Course::class, 'categoryable');
    }

    //has one user
    //has many comments
}
