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
            'dates' => $this->getActivities($user)
        ]);
    }

    private function getActivities($user)
    {
        return $user->activities()
            ->latest()
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('y-m-d');
            });
    }
}
