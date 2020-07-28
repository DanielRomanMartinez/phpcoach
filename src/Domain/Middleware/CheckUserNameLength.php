<?php

namespace App\Domain\Middleware;
use App\Domain\Command\PutUser;
use App\Domain\Model\User\NameTooShortException;
use Drift\CommandBus\Middleware\DiscriminableMiddleware;
use function React\Promise\reject;

/**
 * Class CheckUserNameLength
 * @package App\Domain\Middleware
 */
class CheckUserNameLength implements DiscriminableMiddleware
{

    /**
     * @param PutUser $command
     * @param callable $next
     */
    public function execute(PutUser $command, callable $next)
    {
        if(strlen($command->getUser()->name()) < 5){
            return reject(new NameTooShortException());
        }
        return $next($command);
    }

    /**
     * @return array
     */
    public function onlyHandle(): array
    {
        return [
            PutUser::class
        ];
    }
}