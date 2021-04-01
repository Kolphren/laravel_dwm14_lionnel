<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Book extends Model
{
    public static function getOne($id)
    {
        return Book::find($id);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public static function addBook(Request $request)
    {
        $book = new Book;
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->description = $request->description;
        $book->pages_nb = $request->pages_nb;
        $book->publication_year = $request->publication_year;
        $book->save();
        $book->genres()->attach($request->genres);

        return $book;
    }

    public static function updateBook($book, $data)
    {
        $book->title = $data['title'];
        $book->author_id = $data['author_id'];
        $book->description = $data['description'];
        $book->pages_nb = $data['pages_nb'];
        $book->publication_year = $data['publication_year'];
        $book->save();

        return $book;
    }
}
