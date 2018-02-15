<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Reply;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }
}
