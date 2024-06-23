<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UpdateController extends Controller
{
    public function __invoke(User $user)
    {
        $data = request()->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'role' => 'required|string',
        ]);

        $user->update($data);
        return response()->json(['message' => 'User update successfully'], 200);
    }
}
