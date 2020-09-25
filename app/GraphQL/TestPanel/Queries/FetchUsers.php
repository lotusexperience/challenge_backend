<?php

namespace App\GraphQL\TestPanel\Queries;

use App\GraphQL\QueryPaginated;
use App\User;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class FetchUsers extends QueryPaginated
{
    /**
     * @return array
     */
    protected function args(): array
    {
        return [
            'like' => Type::string(),
        ];
    }

    /**
     * @return Type
     */
    protected function typeResult(): Type
    {
        return new ObjectType([
            'name' => 'FetchUsersResult',
            'fields' => [
                'id' => Type::int(),
                'name' => Type::string(),
                'email' => Type::string(),
            ],
        ]);
    }

    /**
     * @param $root
     * @param $args
     * @return array
     */
    protected function resolve($root, $args): array
    {
        $builder = User::query();

        /*
         * Fetch paginate
         */
        $limit = isset($args['limit']) ? $args['limit'] : 15;
        $users = $builder->paginate($limit);

        return $users->toArray();
    }
}
