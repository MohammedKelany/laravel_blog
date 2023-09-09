<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, "home"])
    ->name('home.index');

Route::get('/contact', [HomeController::class, "contact"])
    ->name('home.contact');

Route::get('/about', AboutController::class)->name('about');

Route::resource("posts", PostController::class);

Auth::routes();

// Route::get('/posts', function () use ($posts) {

//     // Dumping all data in query parameter
//     // dd(request()->all());

//     // Dumping input from query parameter
//     // dd((int)request()->input("id", 12));

//     // Dumping input from query parameter
//     // dd((int)request()->query("id", 12));

//     // Dumping if input is put in the query parameter or not
//     // dd(request()->has(["id", "name"]));~
//     // dd(request()->hasAny(["id", "name"]));
//     // dd(request()->whenHas("id", function () {
//     //     echo "this is when has the id";
//     // }));
//     // dd(request()->filled(["id", "name"]));
//     // dd(request()->anyFilled(["id", "name"]));
//     // dd(request()->isNotFilled(["id", "name"]));
//     // dd(request()->whenFilled("id", function () {
//     //     echo "filled";
//     // }));
//     return view("posts/index", ["posts" => $posts]);
// });

// Route::get('/posts/{id}', function ($id) use ($posts) {
//     abort_if(!isset($posts[$id]), 404);
//     return view("posts.show", ["post" => $posts[$id]]);
// })->name('posts.show');

Route::get('/recent_posts/{days_ago?}', function ($day = 10) {
    return "Posted From $day days ago";
})->name('posts');
Route::get('/posts/tag/{id}', [TagController::class, "index"])->name('posts.tags.index');

Route::resource('posts.comments', PostCommentController::class)->only(["index", "store"]);
Route::resource('users', UserController::class)->only(["show", "update", "edit"]);
Route::resource('users.comments', UserCommentController::class)->only(["store"]);

// Making a prefix for group of routes
// Route::prefix("/fun",)->name("fun.")->group(function () use ($posts) {

//     // Making response for getting the posts
//     Route::get('/responses', function () use ($posts) {
//         return response($posts, 201)
//             ->header("Content-Type", "application/json")
//             ->cookie("MY_NAME", "MOHAMMED FATHY ALi", 120);
//     })->name("responses");

//     // Reload the page
//     Route::get('/back', function () {
//         return back();
//     })->name('back');

//     // Redirect To home by route 
//     Route::get('/redirect', function () {
//         return redirect("/");
//     })->name('redirect');

//     // Redirect To home by route name
//     Route::get('/redirect-route', function () {
//         return redirect()->route("home.index");
//     })->name('redirect-route');

//     // Redirect away from website to google
//     Route::get('/away', function () {
//         return redirect()->away("http://www.google.com");
//     })->name('away');

//     // Reload the page
//     Route::get('/redirect-back', function () {
//         return redirect()->back();
//     })->name('redirect-back');

//     //Getting Json as response
//     Route::get('/json', function () use ($posts) {
//         return response()->json($posts);
//     })->name('json');
//     Route::get('/download', function () {
//         return response()->download(public_path("/my_photo.jpg"));
//     })->name('download');
// });