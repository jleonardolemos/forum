<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use App\Reply;

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

    public function delete($channelSlug, Thread $thread, Reply $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();
        return back()->with('flash', 'Reply deleted');
    }
}
