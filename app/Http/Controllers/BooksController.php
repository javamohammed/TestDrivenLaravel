<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BooksController extends Controller
{
    //

    public function store()
    {
        Book::create( $this->ValidateRequest());
    }

    public function update(Book $book)
    {
        $book->update( $this->ValidateRequest());
    }

    protected function ValidateRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
    }
}
