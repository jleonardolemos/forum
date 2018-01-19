<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Channel;
use App\User;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index(Channel $channel)
    {
        if ($channel->id) {
            $threadsBuilder = $channel->threads()->latest();
        } else {
            $threadsBuilder = Thread::latest();
        }
        
        if (request('user')) {
            $user = User::where('name', request('user'))->firstOrFail();
            $threadsBuilder->where('user_id', $user->id);
        }

        $threads = $threadsBuilder->get();
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
