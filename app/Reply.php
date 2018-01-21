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

    public function favorite()
    {
        $userId = auth()->user()->id;
        if (!$this->favorites()->where('user_id', $userId)->exists()) {
            $this->favorites()->create(['user_id' => $userId]);
        }
    }

    public function isFavorite()
    {
        if (auth()->user()) {
            return $this->favorites()
                ->where('user_id', auth()->user()->id)
                ->exists();
        }

        return true;
    }
}
