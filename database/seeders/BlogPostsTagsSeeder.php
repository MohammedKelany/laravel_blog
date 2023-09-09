<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogPostsTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tagsCount = Tag::all()->count();
        if ($tagsCount == 0) {
            $this->command->info("there are no tags");
            return;
        }
        BlogPost::all()->each(function ($blog) use ($tagsCount) {
            $take = random_int(0, $tagsCount);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck("id");
            $blog->tags()->sync($tags);
        });
    }
}
