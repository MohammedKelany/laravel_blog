<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\BlogPost;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except(["show"]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("posts/index", [
            "posts" => BlogPost::latest()
                ->withCount("comment")
                ->with("user")
                ->with("tags")
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        // requests using model mass assignment and PostRequest class created
        // $validated = $request->validated();
        // $post = BlogPostModel::create($validated);
        // return redirect()->route("posts.show", ["post" => $post->id]);

        //requests using request class
        $validated = $request->validated();
        $post = new BlogPost();
        $post->title = $validated["title"];
        $post->content = $validated["content"];
        $post->user_id = Auth::user()->id;
        $post->save();

        if ($request->hasFile("thumbnail")) {
            $path = $request->file("thumbnail")->store("thumbnails");
            if ($post->image) {
                Storage::delete($post->image->image);
                $post->image->path = $path;
            } else {
                $post->image()->save(
                    Image::make(["path" => $path]),
                );
            }
        }
        $request->session()->flash('status', "The Blog Post is Created!");
        return redirect()->route("posts.show", ["post" => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(!isset($this->posts[$id]), 404);
        return view("posts.show", [
            "post" => BlogPost::with(["comment" => function ($query) {
                return $query->latest();
            }])->with("comment.user")->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize($post);
        return view("posts.edit", ["post" => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, string $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize($post);
        $validated = $request->validated();
        $post->fill($validated);
        $post->save();
        if ($request->hasFile("thumbnail")) {
            $path = $request->file("thumbnail")->store("thumbnails");
            if ($post->image) {
                Storage::delete($post->image->image);
                $post->image->path = $path;
            } else {
                $post->image()->save(
                    Image::make(["path" => $path]),
                );
            }
        }
        $request->session()->flash('status', "The Blog Post is Updated!");
        return redirect()->route("posts.show", ["post" => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize($post);
        $post->delete();
        return redirect()->route("posts.index");
    }
}
