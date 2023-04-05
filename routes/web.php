<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ---------outside of Auth
Route::get('/',[PostController::class,'index'])->name('index');
// Route::get('/card-footer',[PostController::class,'card-footer'])->name('card-footer');
Route::get('/home',[PostController::class,'index'])->name('index');

Route::group(['prefix'=>'profile','as'=>'profile.'], function(){
    // going to profile page
    Route::get('/{id}',[UserController::class,'show'])->name('show');
});

Route::group(['prefix'=>'post','as'=>'post.'], function(){
    // // showing the post we click
    Route::get('/{id}/show',[PostController::class,'show'])->name('show');
});
//

Route::group(['middleware'=>'auth'],function(){

    Route::group(['prefix'=>'post','as'=>'post.'], function(){
        Route::get('/create',[PostController::class,'create'])->name('create');
        // // storing the form to the db
        Route::post('/store',[PostController::class,'store'])->name('store');
        // // going to edit method
        Route::get('/{id}/edit',[PostController::class,'edit'])->name('edit');
        // // going to update method
        Route::patch('/{id}/update',[PostController::class,'update'])->name('update');
        // // destroy
        Route::delete('/{id}/destroy',[PostController::class,'destroy'])->name('destroy');
    });

    Route::group(['prefix'=>'comment','as'=>'comment.'], function(){
        Route::post('/{post_id}/store',[CommentController::class, 'store'])->name('store');
        Route::delete('/{id}/destroy',[CommentController::class,'destroy'])->name('destroy');
        Route::patch('/{comment_id}/update',[CommentController::class,'update'])->name('update');
    });

    // profile group
    Route::group(['prefix'=>'profile','as'=>'profile.'], function(){
        // going to profile page
        Route::get('/{id}/edit',[UserController::class,'edit'])->name('edit');
        Route::patch('/update',[UserController::class,'update'])->name('update');
        Route::delete('/{id}/destroy',[UserController::class,'destroy'])->name('destroy');
    });

    Route::group(['prefix'=>'follow','as'=>'follow.'], function(){
        // going to profile page
        Route::get('/{id}/followers',[FollowController::class,'followers'])->name('followers');
        Route::get('/{id}/following',[FollowController::class,'following'])->name('following');
        Route::post('/{followee_id}/{follower_id}/follow',[FollowController::class,'follow'])->name('follow');
        Route::delete('/{followee_id}/{follower_id}/unfollow',[FollowController::class,'unfollow'])->name('unfollow');
    });

    Route::group(['prefix'=>'like','as'=>'like.'], function(){
        Route::post('/{user_id}/{post_id}/addLike',[LikeController::class, 'addLike'])->name('addLike');
        Route::delete('/{user_id}/{post_id}/removeLike',[LikeController::class, 'removeLike'])->name('removeLike');
    });

});