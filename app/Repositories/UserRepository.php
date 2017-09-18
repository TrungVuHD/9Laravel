<?php

namespace App\Repositories;

use App\User;

class UserRepository extends BaseRepository {
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
