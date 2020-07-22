<?php

namespace App\Domain\Model\User;

/**
 * Class User
 * @package App\Domain\Model
 */
final class User
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $name;

    /**
     * User constructor.
     * @param string $uid
     * @param string $name
     */
    public function __construct(string $uid, string $name)
    {
        $this->uid = $uid;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function uid(): string
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }
}