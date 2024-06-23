<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class LendController extends Controller
{
    public function __invoke(Book $book)
    {
        if ($book->issued_user === true) return response()->json(['error' => 'User already has the book']);

        $book->update([
            'issued_user' => true,
        ]);

        return response()->json(['message' => 'Book lended successfuly']);
    }
}
