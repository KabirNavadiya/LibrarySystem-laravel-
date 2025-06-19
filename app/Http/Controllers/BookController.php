<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBookRequest;
use App\Http\Requests\EditBookRequest;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class BookController extends Controller
{

    // load add book form
    public function addBookForm(){
        return view('admin.addbook');
    }

    // add a new book
    public function addBook(AddBookRequest $request, Book $book){

        // Insert Data into Book Model
        $data = [
            'title' => $request->input('title'),
            'author' => $request->input('author')
            ];

        $book = new Book();
        $book->insertBook($data);
        return redirect()->route('app_add_book')->with('success', 'Book added successfully!');
    }

    public function editBookForm(Book $book, int $id){

        // Fetch the book by ID
        $book = Book::getBookWithId($id);
        return view('admin.editbook',[
            'book'=>$book
        ]);
    }

    public function editBook(EditBookRequest $request, Book $book, int $id){
        $data = [
            'title' => $request->input('title'),
            'author' => $request->input('author')
        ];
        $book->updateBook($id,$data);
        return redirect()->route('app_homepage')
                         ->with('success', 'Book updated successfully!');
    }
    public function deleteBook(int $id,Book $book){
        $book->deleteBook($id);
        return redirect()->route('app_manage_books')->with('success', 'Book deleted successfully!');
    }
}
