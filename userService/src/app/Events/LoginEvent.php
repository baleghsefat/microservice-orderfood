<?php

namespace App\Events;

use App\Models\User;

class LoginEvent extends Event
{
    /**
     * @param User $user User.
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
