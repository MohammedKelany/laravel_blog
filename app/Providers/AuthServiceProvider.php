<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use App\Policies\BlogPostPolicy;
use App\Policies\CommentPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        BlogPost::class => BlogPostPolicy::class,
        User::class => UserPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate::before(function (User $user, $ability) {
        //     if ($user->is_admin and in_array($ability, ["update", "delete"])) {
        //         return true;
        //     }
        // });
    }
}
