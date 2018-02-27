<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use App\Thread;
use App\Channel;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    private function getThreads($channel, $filters)
    {
        $threadsBuilder = Thread::latest()->filter($filters);

        if ($channel->id) {
            $threadsBuilder->where('channel_id', $channel->id);
        }

        return $threadsBuilder->get();
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

        return redirect($thread->route)->with('flash', 'Thread created');
    }

    public function show($chanelId, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(20)
        ]);
    }

    public function destroy($chanelId, Thread $thread)
    {
        $this->authorize('delete', $thread);
        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('threads.index'));
    }
}
