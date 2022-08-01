<?php

namespace App\Http\Middleware;
use App\Helpers\APIHelpers;

use Closure;

class CheckGuest
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
        if(auth()->user()){
            return $next($request);
        }else{
            $gusetkey = $request->header('Authorization');
            if($gusetkey == '$2y$12$ZtgKLOyfvyXH33JE67Ei0.qupt771t62d21M4/OJumBmsZ1bexxpNogulf'){
                return $next($request);
            }
            $response = APIHelpers::createApiResponse(true , 401 , 'Wrong Guest Token' , 'توكن زائر خاطيء' , null , $request->lang);
            return response()->json($response , 401);
        }
    }
}
