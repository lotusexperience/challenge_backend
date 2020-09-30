<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Schemas Config
    |--------------------------------------------------------------------------
    |
    | You must provide all information related to your Schema GraphQL.
    |
    */
    'schemas' => [
        'test-panel' => [
            'queries' => [
                'fetchUsers' => \App\GraphQL\TestPanel\Queries\FetchUsers::class,
            ],
            'mutations' => [
                'auth' => \App\GraphQL\TestPanel\Mutations\Auth::class,
                'signup' => \App\GraphQL\TestPanel\Mutations\Signup::class,
            ],
        ],
    ],
];
