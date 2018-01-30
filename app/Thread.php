<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Activityable;

class Thread extends Model
{
    use Activityable;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('replyCount', function ($query) {
            $query->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }

    public function getRouteAttribute()
    {
        return route('threads.show', [
            'channel' => $this->channel->slug,
            'thread' => $this->id
        ]);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reply($reply)
    {
        $this->replies()->create($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function scopeFilter($query, $filters)
    {
        $filters->apply($query);
    }
}
