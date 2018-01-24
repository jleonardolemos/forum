<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

trait Favoritable
{
    public function favorite()
    {
        $userId = auth()->user()->id;
        !$this->favorites()->where('user_id', $userId)->exists() &&
            $this->favorites()->create(['user_id' => $userId]);
    }

    public function isFavorite()
    {
        if (auth()->user()) {
            return !! $this->favorites
                ->where('user_id', auth()->user()->id)
                ->count();
        }

        return true;
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
