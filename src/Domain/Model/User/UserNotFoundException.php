<?php

namespace App\Domain\Model\User;

use Exception;

class UserNotFoundException extends Exception
{
    /**
     * Create user not found.
     *
     * @param string $uid
     *
     * @return self
     */
    public static function createFromUid(string $uid): self
    {
        return new self(sprintf('User %s not found in repository', $uid));
    }
}