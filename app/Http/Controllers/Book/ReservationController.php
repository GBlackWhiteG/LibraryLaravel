<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function __invoke(Book $book)
    {
        if ($book->user_id !== null) return response()->json(['error' => 'Book already reservated']);

        $data = request()->validate([
            'start_reservation' => 'required|date_format:Y-m-d',
            'end_reservation' => 'required|date_format:Y-m-d',
        ]);

        $book->update([
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name,
            'start_reservation' => Carbon::createFromFormat('Y-m-d', $data['start_reservation']),
            'end_reservation' => Carbon::createFromFormat('Y-m-d', $data['end_reservation']),
        ]);

        return response()->json(['message' => 'Book reservated successfuly']);
    }
}
