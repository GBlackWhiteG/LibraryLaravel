<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class UnReservationController extends Controller
{
    public function __invoke(Book $book)
    {
        if ($book->user_id !== auth()->user()->id) return response()->json(['error' => 'Book reservated by different user']);
        else if ($book->issued_user) return response()->json(['error' => 'User already has the book']);

        $book->update([
            'user_id' => null,
            'user_name' => null,
            'start_reservation' => null,
            'end_reservation' => null
        ]);
        return response()->json(['message' => 'Book unreservated successfuly']);
    }
}
