<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class CheckinBookController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Book $book)
    {
        $book->checkin(auth()->user());
    }
}
