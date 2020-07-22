<?php

namespace App\Domain\Query;

/**
 * Class GetUser
 * @package App\Domain\Query
 */
final class GetUser
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