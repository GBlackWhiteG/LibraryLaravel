<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class UpdateController extends Controller
{
    public function __invoke($id) 
    {
        $book = Book::findOrFail($id);

        $data = request()->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'category' => 'required|string',
            'image_url' => 'required|string'
        ]);

        $book->update($data);
        return response()->json(['message' => 'Book updated successfully'], 200);
    }
}