<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($tagId)
    {
        $tag = Tag::findOrFail($tagId);
        return view("posts.index", ["posts" => $tag->blog_posts]);
    }
}
