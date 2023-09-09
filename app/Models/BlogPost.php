<?php

namespace App\Models;

use DeleteAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;
    protected $fillable = ["title", "content"];
    use HasFactory;
    public function comment()
    {
        return $this->morphMany("App\Models\Comment", "commentable");
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function tags()
    {
        return $this->belongsToMany("App\Models\Tag")->withTimestamps();
    }
    public function image()
    {
        return $this->morphOne("App\Models\Image", "imageable");
    }
    public function scopeLatest(Builder $builder)
    {
        return $builder->orderBy(static::CREATED_AT, "desc");
    }
    public function scopeMostCommented(Builder $builder)
    {
        return $builder->withCount("comment")->orderBy("comment_count", "desc");
    }
    public static function boot()
    {
        // static::addGlobalScope(new DeleteAdminScope);
        parent::boot();
        static::deleting(function (BlogPost $post) {
            $post->comment()->delete();
        });
        static::restoring(function (BlogPost $post) {
            $post->comment()->restore();
        });
    }
}
