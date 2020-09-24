<?php

namespace App\GraphQL;

use Exception;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

class SchemaFactory
{
    /**
     * @return Schema
     * @throws Exception
     */
    public function create($access)
    {
        $config = config('graphql');

        if(!isset($config['schemas'])) {
            throw new Exception('Schemas not found.');
        }

        if(!isset($config['schemas'][$access])) {
            throw new Exception('Access "'.$access.'" not found.');
        }

        $group = $config['schemas'][$access];

        return new Schema([
            'query' => $this->createQuery($group),
            'mutation' => $this->createMutation($group)
        ]);
    }

    /**
     * @return ObjectType
     * @throws Exception
     */
    public function createQuery($group)
    {
        if(!isset($group['queries'])) {
            return null;
        }

        $fields = [];

        foreach ($group['queries'] as $key => $value) {
            $fields[$key] = app()->make($value)->getConfig();
        }

        return new ObjectType([
            'name' => 'QueryRoot',
            'fields' => $fields
        ]);
    }

    /**
     * @return ObjectType
     * @throws Exception
     */
    private function createMutation($group)
    {
        if(!isset($group['mutations'])) {
            return null;
        }

        $fields = [];

        foreach ($group['mutations'] as $key => $value) {
            $fields[$key] = app()->make($value)->getConfig();
        }

        return new ObjectType([
            'name' => 'MutationRoot',
            'fields' => $fields
        ]);
    }
}
