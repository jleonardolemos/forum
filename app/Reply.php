<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    protected $guarded = [];

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

    public function Favorite()
    {
        $userId = auth()->user()->id;
        if (!$this->favorites()->where('user_id', $userId)->exists()) {
            $this->favorites()->create(['user_id' => $userId]);
        }
    }
}
