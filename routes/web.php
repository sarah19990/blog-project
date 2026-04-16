<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::post('/posts/{post}/bookmark', [PostController::class, 'bookmark'])->name('posts.bookmark');
Route::delete('/posts/{post}/bookmark', [PostController::class, 'unbookmark'])->name('posts.unbookmark');
Route::get('/saved-posts', [PostController::class, 'savedPosts'])->name('posts.saved');
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
Route::post('/comments/{comment}/dislike', [CommentController::class, 'dislike'])->name('comments.dislike');
Route::post('/comments/{comment}/report', [CommentController::class, 'report'])->name('comments.report');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
Route::patch('/comments/{comment}/pin', [CommentController::class, 'pinned'])->name('comments.pinned');