<?php

namespace App\Http\Middleware;

use Closure;

class CheckIfUserHasUserInfo
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
    	$current_user = backpack_user();
    	$response = $next($request);
    	if(empty($current_user->userInfo) || $current_user->active == 0) {
    		// redirect to the correct route where the user is prompted to set basic info of it's account
    		return redirect()->route('backpack.account.create');
	    }


        return $response;
    }
}
