<?php

namespace App\Http\Middleware;

use Closure;

class IsUserCompany
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

    	if( !backpack_user()->hasAnyRole(['Webmaster', 'Admin', 'Coach'])) {
	        if($request->company_id) {
		        if(backpack_user()->company->id !== (int)$request->company_id) {
			        \Alert::error('Het bedrijf dat u wilt bezoeken, is niet uw bedrijf.')->flash();
			        return back();
			    }
		        if(!empty($request->id) && !((int)$request->id == in_array((int)$request->id, backpack_user()->company->getEmployeeIds()))) {
			        \Alert::error('De medewerker dat u wilt bekijken behoort niet tot uw bedrijf.')->flash();
			        return back();
		        }
		    } elseif(!$request->company_id && $request->id) {
	            if(backpack_user()->company->id !== (int)$request->id) {
		            \Alert::error('Het bedrijf dat u wilt bezoeken, is niet uw bedrijf.')->flash();
		            return back();
			    }
		    }
	    }
        return $response;
    }
}
