<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NoteController;

// 主页
Route::get('/', function () {
    return Inertia::render('Index');
});

// 笔记
Route::prefix('/note')->group(function () {
    // 跳转笔记上传页面
    Route::get('/create', [NoteController::class, 'create'])
        ->name('note.create');
    // 笔记上传保存
    Route::post('/upload', [NoteController::class, 'upload'])
        ->name('note.upload');
    // 点击笔记
    Route::get('/{menuName}/{bookName}/{noteName}', [NoteController::class, 'show'])
        ->name('note.show');

    // 页头目录创建
    Route::post('/menu/store', [MenuController::class, 'store'])
        ->name('menu.store');
    // 点击页头目录跳转
    Route::get('/{menuName}', [MenuController::class, 'show'])
        ->name('menu.show');

    // 创建书
    Route::post('/book/store', [BookController::class, 'store'])
        ->name('book.store');
    // 点击书
    Route::get('/{menuName}/{bookName}', [BookController::class, 'show'])
        ->name('book.show');
});
