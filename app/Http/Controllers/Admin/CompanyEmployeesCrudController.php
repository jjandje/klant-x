<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyEmployeesRequest;
use App\Http\Requests\CompanyEmployeesUpdateRequest;
use App\Mail\UserWelcomeMail;
use App\Models\BackpackUser;
use App\Models\Company;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

/**
 * Class CompanyEmployeesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CompanyEmployeesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

	public function __construct(  ) {
		// check if currently logged in user is of role companyowner or has the companyowner permissions
		$this->middleware('iscompanyowner');
		parent::__construct();
    }

    public function setup() {
    	$company_id = \Route::current()->parameter('company_id');
		$this->crud->setModel('App\Models\BackpackUser');
		$this->crud->setRoute(config('backpack.base.route_prefix') . '/company/'.$company_id.'/employees');
		$this->crud->setEntityNameStrings( 'medewerker(s)', 'medewerkers');
		$this->crud->addClause('whereHas', 'companies', function($companies) use ($company_id) {
			$companies->where('id', $company_id)->whereHas('users');
		});
	    if(!backpack_user()->hasAnyRole(['Webmaster', 'Admin'])) {
		    $this->crud->denyAccess('update');
		    $this->crud->denyAccess('delete');
		    $this->crud->removeButtons(['update', 'delete']);
	    }
    }

	protected function setupListOperation() {
		$this->crud->setFromDb();
		$this->crud->addColumn([
			'name'              => 'coachnames',
			'label'             => 'Coach(es)',
			'type'              => 'model_function',
			'function_name'     => 'getCoachNames',
		]);
	}

	protected function setupCreateOperation()
	{
		$this->crud->setValidation(CompanyEmployeesRequest::class);
		$this->crud->addField([
			'name'              => 'emails',
			'label'             => 'Email adressen medewerkers',
			'type'              => 'table',
			'entity_singular'   => 'Medewerker',
			'columns'           => [
				'email' => 'Email',
			],
			'min'               => 1,
		]);

		$this->crud->addField([
			'name'              => 'coaches',
			'label'             => 'Coach(es) toewijzen <small>(Optioneel)</small>',
			'entity'            => 'coaches',
			'attribute'         => 'name',
			'type'              => 'select2_multiple',
			'pivot'             => true,
			'model'             => 'App\Models\BackpackUser',
			'options'           => (function($query) {
				return $query->whereHas('roles', function($q) {
					return $q->where('role_id', Role::where('name', 'Coach')->first()->id);
				})->get();
			}),
		]);
	}

	public function store( CompanyEmployeesRequest $request ) {
    	if(!\Route::current()->parameter('company_id')) return response()->json(['error' => 'Er is wat mis gegaan, probeer het opnieuw.']);
    	$emails = $request->get('emails');
    	if(!$emails) return response()->json(['error' => 'We hebben geen emailadressen kunnen vinden, probeer het opnieuw.']);

    	$emails = json_decode($emails);
    	$company_id = \Route::current()->parameter('company_id');

    	$coaches = $request->get('coaches');

    	foreach($emails as $emailObj) {
    		$email = $emailObj->email;
    		if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
			    // create a user with random password
			    $password = Str::random(10);
			    $user = new BackpackUser();
			    $user->active = 0;
			    $user->email = $email;
			    $user->password = Hash::make($password);
			    $userSaved = $user->save();

			    if($userSaved) {
				    // attach correct role to user
				    $user->assignRole( 'User' );
				    // attach user to company
				    $company = Company::find($company_id);
				    $user->companies()->sync($company);

				    if(!empty($coaches)) {
				    	foreach($coaches as $coach_id) {
				    		$user->coaches()->attach($coach_id);
					    }
				    }

				    $user->save();
				    $user = BackpackUser::where('email', $email)->first()->fresh();

				    // send password reset link to user
				    $token = Password::getRepository()->create($user);
				    Mail::to($user->email)->send(new UserWelcomeMail($user, $token));

				    if(Mail::failures()) {
					    // See BackpackUser boot function to see what get's detached / deleted
					    $user->delete();
				    }

				    // show a success message
				    \Alert::success(trans('backpack::crud.insert_success'))->flash();
			    }
		    } else {
    			\Alert::error('Het opgegeven emailadres: '.$email.' is geen geldig emailadres, probeer het opnieuw')->flash();
//    			return back();
		    }
	    }
        return back();
	}

	protected function setupUpdateOperation()
	{
		$this->setupCreateOperation();
		$this->crud->setValidation(CompanyEmployeesUpdateRequest::class);
		$this->crud->removeField('emails');
		$this->crud->addField([
			'name'              => 'coaches',
			'label'             => 'Coach(es) toewijzen',
			'entity'            => 'coaches',
			'attribute'         => 'name',
			'type'              => 'select2_multiple',
			'pivot'             => true,
			'model'             => 'App\Models\BackpackUser',
			'options'           => (function($query) {
				return $query->whereHas('roles', function($q) {
					return $q->where('role_id', Role::where('name', 'Coach')->first()->id);
				})->get();
			}),
		]);
	}

}
