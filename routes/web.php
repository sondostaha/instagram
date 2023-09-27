<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('home',[PostController::class ,'index'])->name('home');

Route::resource('posts',PostController::class);

Route::get('unFollowedFriends',[UserController::class,'unFollowedFriends'])->name('unFollowedFriends');

Route::get('showFriends',[UserController::class,'showFriends'])->name('showFriends');

Route::post('add_user/{id}',[UserController::class,'store'])->name('addFollower');

Route::post('add/comment',[CommentController::class,'add'])->name('add.comment');

Route::get('chat/{user_id}',[ChatController::class ,'chatForm'])->name('chat.form');
Route::get('chat/{user_id}',[ChatController::class ,'sendMessage'])->name('send.message');

require __DIR__.'/auth.php';
