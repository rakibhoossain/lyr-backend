<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    //has many post
    public function courses()
    {
    	return $this->morphedByMany(Course::class, 'taggable');
    }

    //has many course
    public function posts()
    {
    	return $this->morphedByMany(Post::class, 'taggable');
    }

    //has one user
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
