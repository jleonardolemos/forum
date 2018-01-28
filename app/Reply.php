<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activityable;
use App\Favoritable;

class Reply extends Model
{

    use Favoritable, Activityable;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

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
}
