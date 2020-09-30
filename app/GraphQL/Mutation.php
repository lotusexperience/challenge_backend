<?php

namespace App\GraphQL;

use App\GraphQL\AdminPanel\CheckAdmin;
use App\GraphQL\ShipperPanel\CheckShipper;
use App\GraphQL\ShippingCarrierPanel\CheckShippingCarrier;
use Closure;
use GraphQL\Type\Definition\Type;

abstract class Mutation
{
    /**
     * @var array
     */
    private $config;

    /**
     * Query constructor.
     */
    public function __construct()
    {
        $this->config = [
            'type' => $this->typeResult(),
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
     * @return mixed
     */
    protected abstract function resolve($root, $args);

    /**
     * @return Closure
     */
    private function resolveFunction()
    {
        return function ($root, $args) {
            $uses = array_flip(class_uses_recursive(static::class));

            if (isset($uses[AuthRequired::class])) {
                $this->checkAuth();
            }

            if (isset($uses[CheckShipper::class])) {
                $this->isShipper();
            }

            if (isset($uses[CheckAdmin::class])) {
                $this->isAdmin();
            }

            if (isset($uses[CheckShippingCarrier::class])) {
                $this->isShippingCarrier();
            }

            return $this->resolve($root, $args);
        };
    }

    /**
     * @return array
     */
    private function resolveArgs(): array
    {
        $transformed = collect($this->args())->transform(function ($item, $key){
            if(is_array($item)) {
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
