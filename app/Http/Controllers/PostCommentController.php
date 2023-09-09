<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResourse;
use App\Mail\CommentPosted;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Mail;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->only(["store"]);
    }
    public function index(String $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        return CommentResourse::collection($blogPost->comment()->with("user")->get());
    }
    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comment()->create([
            "content" => $request->input("content"),
            "user_id" => $request->user()->id,
        ]);

        Mail::to($post->user)->later(
            now()->addMinute(),
            new CommentPosted($comment)
        );
        return redirect()->back();
    }
}
