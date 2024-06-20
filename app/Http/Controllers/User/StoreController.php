<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function __invoke()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|string'
        ]);

        $data['password'] = Hash::make($data['password']);
        User::firstOrCreate([
            'email' => $data['email']
        ], $data);
        return response()->json(['message' => 'User created successfully'], 200);
    }
}
