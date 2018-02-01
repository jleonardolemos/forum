<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Activity;

class Favorite extends Model
{
    use Activityable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorited()
    {
        return $this->morphTo();
    }
}
