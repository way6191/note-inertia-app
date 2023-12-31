<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;

// 主页
Route::get('/', function () {
    return Inertia::render('Index');
});

// 登录页
Route::get('/login', [UserController::class, 'login']);
// 用户认证
Route::post('/auth', [UserController::class, 'auth'])
    ->name('login');
// 用户注销
Route::get('/logout', [UserController::class, 'logout'])
    ->middleware('auth');

// 笔记
Route::prefix('/note')->group(function () {
    // 跳转笔记上传页面
    Route::get('/create', [NoteController::class, 'create'])
        ->name('note.create')
        ->middleware('auth');
    // 笔记上传保存
    Route::post('/upload', [NoteController::class, 'upload'])
        ->name('note.upload')
        ->middleware('auth');
    // 点击笔记
    Route::get('/{menuName}/{bookName}/{noteName}', [NoteController::class, 'show'])
        ->name('note.show');

    // 页头目录创建
    Route::post('/menu/store', [MenuController::class, 'store'])
        ->name('menu.store')
        ->middleware('auth');
    // 点击页头目录跳转
    Route::get('/{menuName}', [MenuController::class, 'show'])
        ->name('menu.show');

    // 创建书
    Route::post('/book/store', [BookController::class, 'store'])
        ->name('book.store')
        ->middleware('auth');
    // 点击书
    Route::get('/{menuName}/{bookName}', [BookController::class, 'show'])
        ->name('book.show');
});
