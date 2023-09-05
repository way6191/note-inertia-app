<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Note;
use Inertia\Inertia;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    // 笔记展示
    public function show($menuName, $bookName, $noteName)
    {
        $books = Book::select('menu_name', 'book_name')
            ->where('menu_name', $menuName)
            ->get();

        $notes = Note::select('menu_name', 'book_name', 'note_name')
            ->where('menu_name', $menuName)
            ->where('book_name', $bookName)
            ->get();

        // 该笔记
        $note = Note::where('menu_name', $menuName)
            ->where('book_name', $bookName)
            ->where('note_name', $noteName)
            ->first();

        // $version = date('Y-m-d H:i:s');
        // Inertia::version($version);

        // 展示笔记
        return Inertia::render('Note/Index', [
            'books' => $books,
            'notes' => $notes,
            'content' => $note ? Str::markdown($note->note_content) : null
        ]);
    }

    // 笔记创建
    public function create()
    {
        return Inertia::render('Note/Create', [
            'menu' => request()->menu,
            'book' => request()->book
        ]);
    }

    // 笔记上传
    public function upload()
    {
        $menu = request()->menu;
        $book = request()->book;

        if (request()->hasFile('noteFiles')) {
            // 获取所有笔记
            $fileList = request()->file('noteFiles');
            // 循环存储所有笔记
            foreach ($fileList as $file) {
                // 获取笔记内容
                $noteCotent = $file->get();
                // 获取笔记名字
                $noteName = str_replace(".md", "", $file->getClientOriginalName());
                // 保存
                Note::create([
                    'menu_name' => $menu,
                    'book_name' => $book,
                    'note_name' => $noteName,
                    'note_content' => $noteCotent
                ]);
            }

            // 展示笔记
            return to_route(
                'note.show',
                [
                    'menuName' => $menu,
                    'bookName' => $book,
                    'noteName' => $noteName
                ]
            );
        }
    }
}
