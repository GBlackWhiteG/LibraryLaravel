<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class PickController extends Controller
{
    public function __invoke(Book $book)
    {
        $book->update([
            'user_id' => null,
            'user_name' => null,
            'issued_user' => false,
            'start_reservation' => null,
            'end_reservation' => null,
        ]);

        return response()->json(['message' => 'Book picked successfuly']);
    }
}
