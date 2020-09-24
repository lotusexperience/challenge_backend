<?php

namespace App\GraphQL;

use Exception;
use Illuminate\Support\Facades\Auth;

trait AuthRequired
{
    /**
     * @throws Exception
     */
    public function checkAuth()
    {
        if(!Auth::check()) {
            throw new Exception('Autenticação necessária');
        }
    }
}
