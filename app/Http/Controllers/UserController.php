<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        // $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpdateUserRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize($user);
        return view("users.show", ["user" => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize($user);
        return view("users.edit", ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $this->authorize($user);
        $validated = $request->validated();
        $user->name = $validated["name"];
        $user->locale = $validated["locale"];
        $user->save();
        if ($request->hasFile("avatar")) {
            $path = $request->file("avatar")->store("avatar");
            if ($user->image) {
                Storage::delete($user->image->image);
                $user->image->path = $path;
            } else {
                $user->image()->save(
                    Image::make(["path" => $path]),
                );
            }
        }
        return redirect()->route("users.show", ["user" => $user->id])->withStatus("The User Profile is Updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
