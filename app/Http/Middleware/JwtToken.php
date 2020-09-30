<?php

namespace App\Http\Middleware;

use App\Models\Common\User;
use App\Models\Shipper\Shipper;
use Closure;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class JwtToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->hasHeader('Authorization')) {
            $bearer = $request->header('Authorization');

            /*
             * Check token is valid
             */
            if(is_null($bearer) || empty($bearer) || $bearer == 'Bearer null' || $bearer == 'Bearer true') {
                return response()->json('Invalid token.', 401);
            }

            /*
             * Decode
             */
            $obj = JWT::decode(str_replace('Bearer ', '', $bearer), env('APP_KEY'), array('HS256'));

            /*
             * Set User
             */
            $user = User::findOrFail($obj->user->id);

            /*
             * Set shipper
             */
            if(isset($obj->selected_shipper_id)) {
                $user->setShipperSelected(Shipper::find($obj->selected_shipper_id));
            }

            Auth::setUser($user);
        }

        return $next($request);
    }
}
