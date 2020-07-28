<?php

declare(strict_types=1);

namespace App\Domain\Command;

use App\Domain\Model\User\User;

class DeleteUser
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}