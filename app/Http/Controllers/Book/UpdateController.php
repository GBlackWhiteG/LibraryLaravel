<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function __invoke(Request $request, Book $book) 
    {
        $data = request()->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'publisher' => 'required|string',
            'category' => 'required|string',
            'description' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        if ($request->hasFile('image_url')) {
            if ($book->image_url) {
                Storage::disk('public')->delete($book->image_url);
            }
            $data['image_url'] = $request->file('image_url')->store('images', 'public');
        }

        $book->update($data);
        return response()->json(['message' => 'Book updated successfully'], 200);
    }
}