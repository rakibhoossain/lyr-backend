<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class Tag extends Model
{
    use Sluggable, SoftDeletes, HasFactory;

    protected $fillable = ['name'];

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
