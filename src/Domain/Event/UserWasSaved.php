<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\User\User;

class UserWasSaved
{
    /**
     * @var User
     */
    private User $user;

    /**
     * UserWasSaved constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}