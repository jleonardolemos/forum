<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function favorite(Reply $reply)
    {
        $reply->favorite();
        return !request()->wantsJson() ? back() : null;
    }

    public function unfavorite(Reply $reply)
    {
        $reply->unfavorite();
        return !request()->wantsJson() ? back() : null;
    }
}
