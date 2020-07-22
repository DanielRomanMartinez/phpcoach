<?php

/*
 * This file is part of the DriftPHP package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 */

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Query\GetUser;
use App\Controller\Transformer\UserTransformer;
use Drift\CommandBus\Bus\QueryBus;
use Drift\CommandBus\Exception\InvalidCommandException;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DefaultController.
 *
 * You can run this action by making `curl` to /
 */
class GetUserController
{
    /**
     * @var QueryBus
     */
    private $queryBus;

    /**
     * @param QueryBus $queryBus
     */
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    /**
     * Default path.
     * @param string $uid
     * @return PromiseInterface<User>
     * @throws InvalidCommandException
     */
    public function __invoke(string $uid) : PromiseInterface
    {
        return $this
            ->queryBus
            ->ask(new GetUser($uid))
            ->then(function (User $user) {

                return new JsonResponse(UserTransformer::toArray($user));
            })->otherwise(function(UserNotFoundException $exception){

                return new JsonResponse('User not found', 404);
            });
    }
}
