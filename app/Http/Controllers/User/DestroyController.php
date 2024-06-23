<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DestroyController extends Controller
{
    public function __invoke(User $user) 
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
