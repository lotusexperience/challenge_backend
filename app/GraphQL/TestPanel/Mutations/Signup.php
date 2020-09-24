<?php

namespace App\GraphQL\TestPanel\Mutations;

use App\GraphQL\Mutation;
use App\User;
use GraphQL\Type\Definition\Type;
use Illuminate\Support\Facades\Hash;

class Signup extends Mutation
{
    /**
     * @return array
     */
    protected function args(): array
    {
        return [
            'name' => Type::nonNull(Type::string()),
            'email' => Type::nonNull(Type::string()),
            'password' => Type::nonNull(Type::string()),
        ];
    }

    /**
     * @return Type
     */
    protected function typeResult(): Type
    {
        return Type::boolean();
    }

    /**
     * @param $root
     * @param $args
     * @return bool
     */
    protected function resolve($root, $args): bool
    {
        User::create([
            'name' => $args['name'],
            'email' => strtolower($args['email']),
            'password' => Hash::make($args['password']),
        ]);

        return true;
    }
}
