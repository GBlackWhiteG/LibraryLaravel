<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class ShowController extends Controller
{
    public function __invoke(Book $book)
    {   
        $book->image_url = asset('storage/' . $book->image_url);

        return $book;
    }
}
