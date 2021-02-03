<?php

namespace App\Http\Middleware;

use Closure;

class IsCompanyOwner
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
	    $response = $next($request);

	    if( !backpack_user()->hasAnyRole(['Webmaster', 'Admin', 'Companyowner'])) {
		    \Alert::error('U bent geen bedrijfseigenaar.')->flash();
		    return back();
	    }

	    return $response;
    }
}
