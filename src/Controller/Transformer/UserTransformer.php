<?php

namespace App\Controller\Transformer;

use App\Domain\Model\User\User;

final class UserTransformer
{
    public static function fromArray(array $userData) : User
    {
        return new User(
            $userData['uid'],
            $userData['name'],
        );
    }

    public static function toArray(User $user) : array
    {
        return [
            'uid'  => $user->uid(),
            'name' => $user->name(),
        ];
    }
}