<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Redirect;

class BooksController extends Controller
{
    //

    public function store()
    {
        $book = Book::create( $this->ValidateRequest());
        return Redirect($book->path());
    }

    public function update(Book $book)
    {
        $book->update( $this->ValidateRequest());
        return Redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return Redirect('/books');
    }

    protected function ValidateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
