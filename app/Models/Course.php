<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;

    //has many tags
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    //has many comments
    public function comments()
    {
    	return $this->morphToMany(Comment::class, 'commentable');
    }

    //has many category
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    //has one user
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    //has many students
}
