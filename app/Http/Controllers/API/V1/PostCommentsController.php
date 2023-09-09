<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use App\Http\Resources\CommentResourse;
use App\Mail\CommentPosted;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->only(["store", "destroy", "update"]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        return CommentResourse::collection($blogPost->comment()->with("user")->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comment()->create([
            "content" => $request->input("content"),
            "user_id" => $request->user()->id
        ]);

        Mail::to($post->user)->later(
            now()->addMinute(),
            new CommentPosted($comment)
        );
        return response()->json(new CommentResourse($comment));;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        return CommentResourse::collection($blogPost->comment()->with("user")->get());
        // return response()->json(["comments" => []]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreComment $request, string $_, string $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        $this->authorize($comment);
        $content = $request->validated();
        $comment->fill($content);
        $comment->save();
        return response()->json(new CommentResourse($comment));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $_,  string $comment_id)
    {
        $comment = Comment::findOrfail($comment_id);
        $this->authorize($comment);
        $comment->delete();
        return response()->json([
            "status" => true,
            "message" => "$comment->id deleted Successfully"
        ]);
    }
}
