<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($threadId, Thread $thread)
    {
        $this->validate(request(), [
            'body' => 'required'
        ]);

        $thread->reply([
            'body' => request()->body,
            'user_id' => auth()->user()->id
        ]);

        return back()->with('flash', 'Reply left');
    }
}
