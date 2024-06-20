<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        //return $book;
        
        return Book::findOrFail($id);
    }
}
