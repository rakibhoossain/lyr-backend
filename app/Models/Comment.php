<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = ['content'];
    //has one post
    //has one course
    //has many reply

    //commentable
    public function commentable()
    {
    	return $this->morphTo();
    }
}
