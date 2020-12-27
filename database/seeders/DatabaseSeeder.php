<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Course;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
	use HasFactory;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        User::factory(10)->create()->each(function($user){

            $user->tags()->saveMany(Tag::factory(25)->make());
            $user->categories()->saveMany(Category::factory(20)->make());

            $user->posts()->saveMany(Post::factory(100)->make())->each(function($post){
                $post->tags()->saveMany(Tag::factory(2)->make());
                $post->categories()->saveMany(Category::factory(3)->make());
                $post->comments()->saveMany(Comment::factory(15)->make());
            });

            $user->courses()->saveMany(Course::factory(10)->make())->each(function($course){
                $course->tags()->saveMany(Tag::factory(2)->make());
                $course->categories()->saveMany(Category::factory(3)->make());
                $course->comments()->saveMany(Comment::factory(4)->make());
            });
        });
    }
}
