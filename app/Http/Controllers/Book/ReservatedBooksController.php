<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class ReservatedBooksController extends Controller
{
    public function __invoke()
    {
        $books = Book::whereNotNull('user_id')->get();
        return $books;
    }
}
