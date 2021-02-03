<?php

namespace App\Http\Controllers;

use App\Mail\NewApplicationAdminMail;
use App\Models\Application;
use App\Models\Package;
use App\Http\Requests\Forms\ApplicationFormRequest;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
	public function index(  ) {
//		$packages = Package::all();
//		return view('application.index', ['packages' => $packages]);
		// TODO: We will use packages in V2
		return view('application.index');
    }

	public function store( ApplicationFormRequest $request ) {
		$args = [
			'status'        => 'new',
			'name'          => $request->get('name'),
			'companyname'   => $request->get('company_name'),
			'phonenumber'   => $request->get('phonenumber'),
			'emailaddress'  => $request->get('email'),
			'package'       => $request->get('package'),
			'message'       => $request->get('message'),
		];
		$application = new Application($args);
		$application->save();

		$application = Application::find($application->id)->fresh();

		// Send a email notification about the new application to the site admin
		//Mail::to('example@gmail.com')->send(new NewApplicationAdminMail($application));

		// TODO: maybe send a copy to the user ??

		return redirect('/bedankt')->with('success', 'We hebben uw aanvraag ontvangen!');
    }
}
