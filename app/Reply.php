<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, Activityable;

    protected $fillable = ['thread_id', 'user_id', 'body'];

    protected $with = ['owner', 'favorites'];

    protected $appends = [
        'delete_route',
        'is_favorite',
        'favorite_route',
        'unfavorite_route',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function getDeleteRouteAttribute()
    {
        return route('threads.replies.delete', [
            'channel' => $this->thread->channel->slug,
            'thread' => $this->thread->id,
            'reply' => $this->id,
        ]);
    }

    public function getRouteAttribute()
    {
        return route('threads.show', [
            'channel' => $this->thread->channel->slug,
            'thread' => $this->thread->id
        ]) . '#reply-' . $this->id;
    }

    public function getFavoriteRouteAttribute()
    {
        return route('replies.favorite', $this->id);
    }

    public function getUnfavoriteRouteAttribute()
    {
        return route('replies.unfavorite', $this->id);
    }
}
