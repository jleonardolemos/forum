<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', [
            'profileUser' => $user,
            'threads' => $user->threads()->latest()->paginate(10)
        ]);
    }
}
