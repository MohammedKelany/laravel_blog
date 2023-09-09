<?php

namespace App\Http\ViewComposers;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommentedPosts', 3600, function () {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::remember("mostActiveUsers", 3600, function () {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveThisMonth = Cache::remember("mostActiveUsersThisMonth", 3600, function () {
            return User::withMostBlogPostsThisMonth()->take(5)->get();
        });
        $view->with("mostCommented", $mostCommented);
        $view->with("mostActive", $mostActive);
        $view->with("mostActiveThisMonth", $mostActiveThisMonth);
    }
}
