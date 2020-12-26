<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable, SoftDeletes;
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
    
    protected $fillable = ['name', 'content'];

    public function getRouteKeyName(){
        return 'slug';
    }

    //has many tags
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    //has many category
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    //has many comment
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    //has one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
