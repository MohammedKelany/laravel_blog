<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public const LOCALS = ["en" => "English", "es" => "Espaniol", "de" => "Deutsch"];
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        "locale",
        "email_verified_at",
        "is_admin"
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function blog_posts()
    {
        return $this->hasMany("App\Models\BlogPost");
    }
    public function comment()
    {
        return $this->hasMany("App\Models\Comment");
    }

    public function commentOn()
    {
        return $this->morphMany("App\Models\Comment", "commentable");
    }

    public function image()
    {
        return $this->morphOne("App\Models\Image", "imageable");
    }
    public function scopeWithMostBlogPosts(Builder $builder)
    {
        return $builder->withCount("blog_posts")->orderBy("blog_posts_count", "desc");
    }
    public function scopeWithMostBlogPostsThisMonth(Builder $builder)
    {
        return $builder->withCount(["blog_posts" => function (Builder $query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonth(), now()]);
        }])->has("blog_posts", ">=", 2)->orderBy("blog_posts_count", "desc");
    }
    public static function boot()
    {
        parent::boot();
    }
}
