<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    public $timestamps = true;
    protected $fillable = ['title', 'author'];

    public function getId()
    {
          return $this->id;
    }


    // insert a new book into the database
    public function insertBook($data)
    {
        Book::create([
            'title' => $data['title'],
            'author' => $data['author'],
        ]);
    }

    // fetch all books
    public function getAllBooks(){
        return DB::table('books')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    // fetch a book by ID
    public static function getBookWithId(int $id)
    {
        return DB::table('books')
            ->where('id', $id)
            ->first();
    }
    public function updateBook($id, $data)
    {
        return DB::table('books')
            ->where('id', $id)
            ->update([
                'title' => $data['title'],
                'author' => $data['author'],
                'updated_at' => Carbon::now(),
            ]);
    }

    public function deleteBook(int $id)
    {
        return DB::table('books')
            ->where('id', $id)
            ->delete();
    }
}
