<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Note;
use App\Http\Controllers\NoteController;

class BookController extends Controller
{
    // 创建书
    public function store()
    {
        $menuName = request()->menuName;
        $bookName = request()->bookName;
        // 保存
        Book::create([
            'menu_name' => $menuName,
            'book_name' => $bookName,
        ]);

        // 跳转到空笔记
        return redirect()->action(
            [NoteController::class, 'show'],
            [
                'menuName' => $menuName,
                'bookName' => $bookName,
                'noteName' => "空"
            ]
        );
    }

    // 展示书
    public function show()
    {
        $menuName = request()->menuName;
        $bookName = request()->bookName;

        // 第一条笔记
        $note = Note::where('menu_name', $menuName)
            ->where('book_name', $bookName)
            ->first();

        // 跳转到空笔记
        return redirect()->action(
            [NoteController::class, 'show'],
            [
                'menuName' => $menuName,
                'bookName' => $bookName,
                'noteName' => $note ? $note->note_name : "空"
            ]
        );
    }
}
