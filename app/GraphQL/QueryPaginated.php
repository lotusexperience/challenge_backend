<?php

namespace App\GraphQL;

use Closure;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Illuminate\Pagination\Paginator;

abstract class QueryPaginated
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var ResolveInfo
     */
    protected $resolveInfo;

    /**
     * Query constructor.
     */
    public function __construct()
    {
        $className = get_class($this);

        if ($pos = strrpos($className, '\\')) {
            $className = mb_substr($className, $pos + 1);
        }

        $this->config = [
            'type' => new ObjectType([
                'name' => $className . 'List',
                'fields' => [
                    'total' => Type::int(),
                    'current_page' => Type::int(),
                    'per_page' => Type::int(),
                    'last_page' => Type::int(),
                    'data' => Type::listOf($this->typeResult())
                ]
            ]),
            'args' => $this->resolveArgs(),
            'resolve' => $this->resolveFunction()
        ];
    }

    /**
     * @return array
     */
    protected abstract function args(): array;

    /**
     * @return Type
     */
    protected abstract function typeResult(): Type;

    /**
     * @param $root
     * @param $args
     * @return array
     */
    protected abstract function resolve($root, $args): array;

    /**
     * @return Closure
     */
    private function resolveFunction()
    {
        return function ($root, $args, $context, $info) {
            $this->resolveInfo = $info;

            Paginator::currentPageResolver(function ($pageName = 'page') use ($args) {
                return isset($args[$pageName]) ? $args[$pageName] : 1;
            });

            return $this->resolve($root, $args);
        };
    }

    /**
     * @return array
     */
    private function resolveArgs(): array
    {
        $args = array_merge($this->args(), [
            'page' => Type::int(),
            'limit' => Type::int()
        ]);

        $transformed = collect($args)->transform(function ($item, $key) {
            if (is_array($item)) {
                return $item;
            }

            return [
                'type' => $item,
                'description' => $key
            ];
        });

        return $transformed->toArray();
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }
}
