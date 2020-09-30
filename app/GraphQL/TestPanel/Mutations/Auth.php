<?php

namespace App\GraphQL\TestPanel\Mutations;

use App\GraphQL\Mutation;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Auth as AuthFacade;

class Auth extends Mutation
{
    /**
     * @return array
     */
    protected function args(): array
    {
        return [
            'email' => Type::nonNull(Type::string()),
            'password' => Type::nonNull(Type::string()),
        ];
    }

    /**
     * @return Type
     */
    protected function typeResult(): Type
    {
        return new ObjectType([
            'name' => 'AuthResult',
            'fields' => [
                'id' => Type::int(),
                'email' => Type::string(),
                'name' => Type::string(),
            ],
        ]);
    }

    /**
     * @param $root
     * @param $args
     * @return array
     * @throws \Exception
     */
    protected function resolve($root, $args): array
    {
        /*
         * Check user
         */
        $loginData = [
            'email' => $args['email'],
            'password' => $args['password'],
        ];

        if (AuthFacade::attempt($loginData)) {
            $user = AuthFacade::user();
            return [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
            ];
        }

        throw new \Exception('Credenciais inválidas.', 401);
    }
}
