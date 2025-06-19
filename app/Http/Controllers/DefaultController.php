<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function index(Book $book)
    {
        $fcmToken = session('fcm_token');

        return view('welcome', [
            'books' => $book->getAllBooks(),
            'booksModel' => $book,
            'fcmToken' => $fcmToken
        ]);
    }
    public function saveToken(Request $request)
    {
        $token = $request->input('token');
        session(['fcm_token' => $token]);
        session()->save(); // ✅ Force session write

        return response()->json([
            'status' => 'success',
            'stored_token' => session('fcm_token')
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
