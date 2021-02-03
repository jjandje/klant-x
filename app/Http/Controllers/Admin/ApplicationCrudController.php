<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ApplicationRequest;
use App\Models\Company;
use App\Models\BackpackUser;
use App\Models\UserInfo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Mail;
use App\Mail\ApplicationApproved;
use Illuminate\Support\Facades\Password;

/**
 * Class ApplicationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ApplicationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Application');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/application');
        $this->crud->setEntityNameStrings('aanvraag', 'aanvragen');
        $this->crud->denyAccess(['create']);
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->removeColumn('status');
        $this->crud->addColumn([
        	'name'      => 'status',
	        'label'     => 'Status',
	        'type'      => 'select_from_array',
	        'options'   => ['new' => 'Nieuw', 'approved' => 'Goedgekeurd', 'declined' => 'Afgewezen'],
        ]);
        $this->crud->addColumn([
        	'name'      => 'name',
	        'label'     => 'Naam',
	        'type'      => 'text',
        ]);
        $this->crud->addColumn([
        	'name'      => 'companyname',
	        'label'     => 'Bedrijfsnaam',
	        'type'      => 'text',
        ]);
        $this->crud->addColumn([
        	'name'      => 'phonenumber',
	        'label'     => 'Telefoonnummer',
	        'type'      => 'text',
        ]);
        $this->crud->addColumn([
        	'name'      => 'emailaddress',
	        'label'     => 'Emailadres',
	        'type'      => 'email',
        ]);
        $this->crud->addColumn([
        	'name'      => 'package',
	        'label'     => 'Pakket',
	        'type'      => 'text',
        ]);

        $this->crud->addFilter([
        	'name'      => 'status',
	        'type'      => 'select2',
	        'label'     => 'Status',
        ], function() {
        	return [
        		'new'   => 'Nieuw',
		        'approved'  => 'Goedgekeurd',
		        'declined'  => 'Afgewezen',
	        ];
        }, function ($value) {
        	$this->crud->addClause('where', 'status', $value);
        });
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ApplicationRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
    }

    protected function setupUpdateOperation()
    {
        $this->crud->removeField('status');
        $this->crud->addField(['name' => 'status', 'type' => 'select_from_array', 'options' => ['new' => 'Nieuw', 'approved' => 'Goedkeuren', 'declined' => 'Afwijzen']]);

        $this->crud->addField(['name' => 'name', 'label' => 'Naam', 'type' => 'text']);
        $this->crud->addField(['name' => 'companyname', 'label' => 'Bedrijfsnaam', 'type' => 'text']);
        $this->crud->addField(['name' => 'phonenumber', 'label' => 'Telefoonnummer', 'type' => 'text']);
        $this->crud->addField(['name' => 'emailaddress', 'label' => 'Emailadres', 'type' => 'email']);
        $this->crud->addField(['name' => 'package', 'label' => 'Pakket', 'type' => 'text']);
        $this->crud->addField(['name' => 'message', 'label' => 'Bericht', 'type' => 'textarea']);

//        $this->setupCreateOperation();
    }

	public function update(ApplicationRequest $request) {
		$response = $this->traitUpdate();
		$status = $request->get('status');
		if($status === 'approved') {
			$companyname = $request->get('companyname');
			$name = $request->get('name');
			$emailaddress = $request->get('emailaddress');
			$password = Str::random(10);

			$user = new BackpackUser();
			$user->active = 0;
			$user->email = $emailaddress;
			$user->password = Hash::make($password);
			$userSaved = $user->save();

			$user_info = new UserInfo();
			$user_info->user_id = $user->id;
			$user_info->name = $name;
			$user->userInfo()->save($user_info);
			// set the role to the user
			if($userSaved) {
				$user->assignRole('Companyowner');
				$company = new Company();
				$company->active = 0;
				$company->name = $companyname;
				$company->logo = '-';
				$companySaved = $company->save();
				if($companySaved) {
					$user->companies()->sync($company);

					$token = Password::getRepository()->create($user);
					// send an email to user with credentials including $password
					Mail::to($user->email)->send(new ApplicationApproved($user, $company, $token));
					if(Mail::failures()) {
						$user->removeRole('Companyowner');
						$user->companies()->detach();
						$user->delete();
						$company->delete();
					}
				} else {
					$user->removeRole('Companyowner');
					$user->companies()->detach();
					$user->delete();
					$company->delete();
				}
			} else {
				$user->delete();
			}
		}
		return $response;
    }
}
