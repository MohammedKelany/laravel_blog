<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Mail\CommentPosted;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->only(["store"]);
    }

    public function store(User $user, StoreComment $request)
    {
        $comment = $user->commentOn()->create([
            "content" => $request->input("content"),
            "user_id" => $request->user()->id,
        ]);
        Mail::to($user)->later(
            now()->addMinute(),
            new CommentPosted($comment)
        );
        return redirect()->back();
    }
}
