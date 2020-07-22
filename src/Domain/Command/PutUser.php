<?php

namespace App\Domain\Command;

/**
 * Class PutUser
 * @package App\Domain\Command
 */
class PutUser
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
     * PutUser constructor.
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
    public function getUid(): string
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}