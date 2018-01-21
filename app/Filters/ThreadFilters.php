<?php

namespace App\Filters;

use Illuminate\Http\Request;
use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];
    protected function by($username)
    {
        $user = User::where('name', request('by'))->firstOrFail();
        return $this->builder->where('user_id', $user->id);
    }
}
