<?php

namespace App\Controller;

use App\Controller\Transformer\UserTransformer;
use App\Domain\Command\PutUser;
use App\Domain\Model\User\NameTooShortException;
use Drift\CommandBus\Bus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    public function __invoke(Request $request, string $uid)
    {
        $userData = json_decode($request->getContent(), true);
        $user = UserTransformer::fromArray($uid, $userData);

        return $this
            ->commandBus
            ->execute(new PutUser($user))
            ->then(function () {
                return new Response('OK', 202);
            })->otherwise(function(NameTooShortException $e){
                return new Response($e->getMessage(), 400);
            });
    }
}