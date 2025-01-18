<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/', function () {
    return view('blog');
});
Route::get('/home', [AuthController::class, 'home'])->middleware('auth')->name('home');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/posts', [PostController::class, 'index'])->name('post.index');
Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
Route::post('/posts', [PostController::class, 'store'])->name('post.store');
Route::get('/posts/{post}', [PostController::class, 'showPost'])->name('post.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destroy');
Route::post('/posts/{postId}/like', [PostController::class, 'like'])->name('post.like');


Route::get('/comments/count/{postId}', [CommentController::class, 'count']);
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/reply', [CommentController::class, 'reply'])->name('comments.reply');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
