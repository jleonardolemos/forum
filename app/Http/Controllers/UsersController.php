<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Activity;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', [
            'profileUser' => $user,
            'dates' => Activity::feed($user)
        ]);
    }
}
