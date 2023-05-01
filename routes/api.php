<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SastraController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('authentications', 'login'); // loginPage
    Route::delete('authentications', 'logout'); // logout
});


Route::controller(UserController::class)->group(function () {
    Route::post('users', 'store'); // registerPage
    Route::get('user', 'index'); // profilePage
    Route::patch('users', 'update'); // profilePage
    Route::get('search', 'search'); // input search home
    Route::get('users/{username}', 'userDetail'); // info user
    Route::post('profilepicture', 'crop');
});

Route::controller(SastraController::class)->group(function () {
    Route::get('index', 'index')->name('login');
    Route::get('sastras', 'getSastras'); // homePage
    Route::get('sastras/{username}', 'getSastrasByUser'); //userPage
    Route::get('sastras/{username}/likes', 'getSastrasByLikeUser'); // likePage
    Route::get('sastras/p/{slug}', 'getSastraBySlug'); // detailPage
    Route::post('sastras', 'store'); // add sastra
    Route::delete('sastras/{id}', 'delete'); // delete sastra
});

Route::controller(CommentController::class)->group(function () {
    Route::post('comments', 'store'); // add comment
    Route::delete('comments/{id}', 'delete'); // delete comment
});

Route::controller(LikeController::class)->group(function () {
    Route::post('likes/{sastra_id}', 'index'); // like and unlike
});
