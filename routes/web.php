<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefaultController;

Route::get('/', [DefaultController::class,'index'])->name('app_homepage');
Route::get('/managebooks', [DefaultController::class,'manageBooks'])->name('app_manage_books');
Route::get('/books/add', [BookController::class,'addBookForm'] )->name('app_add_book');
Route::post('/add',[BookController::class,'addBook'])->name('app_add_book_post');
Route::get('/books/edit/{id}',[BookController::class,'editBookForm'])->name('app_edit_book');
Route::post('/books/edit/{id}',[BookController::class,'editBook'])->name('app_edit_book_post');
Route::post('/books/delete/{id}',[BookController::class,'deleteBook'])->name('app_delete_book');
