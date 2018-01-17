<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Channel;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index(Channel $channel)
    {
        if ($channel->id) {
            $threads = $channel->threads()->latest()->get();
        } else {
            $threads = Thread::latest()->get();
        }

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id' => auth()->user()->id,
            'channel_id' => $request->channel_id,
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect($thread->route);
    }

    public function show($chanelId, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }
}
