<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Course extends Model
{
    use Sluggable, SoftDeletes, HasFactory;

    protected $fillable = ['name', 'content'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    //has many tags
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    //has many comments
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
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
