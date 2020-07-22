<?php


namespace App\Controller;

use App\Domain\Command\PutUser;
use Drift\CommandBus\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PutUserController
 * @package App\Controller
 */
class PutUserController
{

    /**
     * @var
     */
    private $commandBus;

    /**
     * PutUserController constructor.
     * @param $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $uid)
    {
        $name = 'Pepe';
        return $this
            ->commandBus
            ->execute(new PutUser($uid, $name))
            ->then(function () {
                return new Response('OK', 202);
            });
    }
}