<?php

namespace App\Domain\Command;

use App\Domain\Model\User\User;

/**
 * Class PutUser
 * @package App\Domain\Command
 */
class PutUser
{
    /**
     * @var User
     */
    private $user;

    /**
     * PutUser constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getUser(): User
    {
        return $this->user;
    }
}