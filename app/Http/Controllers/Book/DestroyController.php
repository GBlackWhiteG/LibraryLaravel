<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class DestroyController extends Controller
{
    public function __invoke(Book $book)
    {
        if ($book->image_url) {
            Storage::disk('public')->delete($book->image_url);
        }

        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
