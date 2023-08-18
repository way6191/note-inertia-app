<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Menu;
use App\Models\Note;
use App\Http\Controllers\NoteController;

class MenuController extends Controller
{
    // 创建页头目录
    public function store()
    {
        // 保存
        Menu::create([
            'menu_name' => request()->menuName,
        ]);

        // 跳转到展示目录
        return to_route(
            'menu.show',
            [
                'menuName' => request()->menuName
            ]
        );
    }

    // 展示目录内容
    public function show($menuName)
    {
        // 获取书
        $books = Book::where('menu_name', $menuName)
            ->get();
        // 有书
        if (count($books) > 0) {
            // 第一本书
            $bookName = $books[0]->book_name;
            // 获取所有笔记
            $notes = Note::select('note_name')
                ->where('menu_name', $menuName)
                ->where('book_name', $bookName)
                ->get();

            // 笔记
            if (count($notes) > 0) {
                // 获取第一条笔记
                $noteName = $notes[0]->note_name;
                // 跳转笔记
                return to_route('note.show', [
                    'menuName' => $menuName,
                    'bookName' => $bookName,
                    'noteName' => $noteName
                ]);
            }

            // 跳转空笔记
            return to_route('note.show', [
                'menuName' => $menuName,
                'bookName' => $bookName,
                'noteName' => "空"
            ]);
        }

        // 跳转空书
        return to_route('note.show', [
            'menuName' => $menuName,
            'bookName' => "空",
            'noteName' => "空"
        ]);
    }
}
