<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\PostCommentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->name("api.v1.")->group(function () {
    Route::get("/status", function () {
        return response()->json(["status" => true]);
    })->name("status");
    Route::apiResource("posts.comments", PostCommentsController::class);
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
});

Route::prefix("v2")->name("api.v2.")->group(function () {
    Route::get("/status", function () {
        return response()->json(["status" => "OK"]);
    })->name("status");
});

Route::fallback(function () {
});
