<?php

namespace App\Http\Controllers;

use App\Models\Book;

class DefaultController extends Controller
{
    public function index(Book $book){

        $books=$book->getAllBooks();
        return view('welcome',[
            'books' => $books,
            'booksModel' => $book
        ]);
    }
    public function manageBooks(Book $book){
        $books = $book->getAllBooks();
        return view('admin.managebooks',[
            'books' => $books,
            'booksModel' => $book
        ]);
    }
}
