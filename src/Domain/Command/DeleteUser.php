<?php

declare(strict_types=1);

namespace App\Domain\Command;

class DeleteUser
{
    /**
     * @var string
     */
    private $uid;

    /**
     * GetValue constructor.
     *
     * @param string $uid
     */
    public function __construct(string $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function uid(): string
    {
        return $this->uid;
    }
}