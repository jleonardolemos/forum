<?php

namespace App;

trait Favoritable
{
    public function favorite()
    {
        $userId = auth()->user()->id;
        !$this->favorites()->where('user_id', $userId)->exists() &&
            $this->favorites()->create(['user_id' => $userId]);
    }

    public function unfavorite()
    {
        $this->favorites()
            ->where('user_id', auth()->user()->id)->get()->each->delete();
    }

    public function isFavorite()
    {
        if (auth()->user()) {
            return !!$this->favorites
                ->where('user_id', auth()->user()->id)
                ->count();
        }

        return true;
    }

    public function getIsFavoriteAttribute()
    {
        return $this->isFavorite();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
