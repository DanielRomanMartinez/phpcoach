<?php

declare(strict_types=1);

namespace App\Domain\Event;

use App\Domain\Model\User\User;

class UserWasDeleted
{
    /**
     * @var User
     */
    private User $user;

    /**
     * UserWasSaved constructor.
     */
    public function __construct()
    {

    }
}