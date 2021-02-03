<?php

namespace App\Http\Controllers\Admin;

use App\Models\BackpackUser;
use App\Models\Company;
use App\Models\UserBmi;
use App\Models\UserInfo;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserWelcomeMail;
use Illuminate\Support\Facades\Password;

class UserCrudController extends CrudController
{
	use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
	use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
	use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

	public function setup()
	{
		$this->crud->setModel(config('backpack.permissionmanager.models.user'));
		$this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
		$this->crud->setRoute(backpack_url('user'));
	}

	public function setupListOperation()
	{
		$this->crud->setColumns([
			[
				'name'  => 'name',
				'label' => trans('backpack::permissionmanager.name'),
				'type'  => 'text',
			],
			[
				'name'  => 'email',
				'label' => trans('backpack::permissionmanager.email'),
				'type'  => 'email',
			],
			[ // n-n relationship (with pivot table)
				'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
				'type'      => 'select_multiple',
				'name'      => 'roles', // the method that defines the relationship in your Model
				'entity'    => 'roles', // the method that defines the relationship in your Model
				'attribute' => 'name', // foreign key attribute that is shown to user
				'model'     => config('permission.models.role'), // foreign key model
			],
			[ // n-n relationship (with pivot table)
				'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
				'type'      => 'select_multiple',
				'name'      => 'permissions', // the method that defines the relationship in your Model
				'entity'    => 'permissions', // the method that defines the relationship in your Model
				'attribute' => 'name', // foreign key attribute that is shown to user
				'model'     => config('permission.models.permission'), // foreign key model
			],
		]);

		// Role Filter
		$this->crud->addFilter([
			'name'  => 'role',
			'type'  => 'dropdown',
			'label' => trans('backpack::permissionmanager.role'),
		],
			config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
			function ($value) { // if the filter is active
				$this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
					$query->where('role_id', '=', $value);
				});
			});

		// Extra Permission Filter
		$this->crud->addFilter([
			'name'  => 'permissions',
			'type'  => 'select2',
			'label' => trans('backpack::permissionmanager.extra_permissions'),
		],
			config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
			function ($value) { // if the filter is active
				$this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
					$query->where('permission_id', '=', $value);
				});
			});
	}

	public function setupCreateOperation()
	{
		$this->addUserFields();
		$this->crud->setValidation(StoreRequest::class);
	}

	public function setupUpdateOperation()
	{
		$this->addUserFields();
		$this->crud->setValidation(UpdateRequest::class);
	}

	/**
	 * Store a newly created resource in the database.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store()
	{
		$this->crud->request = $this->crud->validateRequest();
		$this->crud->request = $this->handlePasswordInput($this->crud->request);
		$this->crud->unsetValidation(); // validation has already been run

		// Store the original storetrait in a variable
		$store = $this->traitStore();

		// Set userInfo and userBmi on creation
		$user_id = $this->crud->entry->id;
		$user = BackpackUser::find($user_id);
		$name = $this->crud->request->request->get('name');

		$user_info = $user->userInfo;
		if(empty($user_info)) {
			$user_info = new UserInfo();
			$user_info->user_id = $user->id;
		}

		$user_info->name = $name;
		$user->userInfo()->save($user_info);

		$user_bmi = $user->userBmi;
		if(empty($user_bmi)) {
			$user_bmi = new UserBmi();
			$user_bmi->user_info_id = $user_info->id;
		}
		$user_bmi->save();
		$user->save();

		$user = BackpackUser::find($user_id)->fresh();

		if($user) {
			$token = Password::getRepository()->create($user);
			// send an welcome email to the newly added user
			Mail::to($user->email)->send(new UserWelcomeMail($user, $token));

			if(Mail::failures()) {
				// See BackpackUser boot function to see what get's detached / deleted
				$user->delete();
			}
		}

		return $store;
	}

	/**
	 * Update the specified resource in the database.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update()
	{
		$this->crud->request = $this->crud->validateRequest();
		$this->crud->request = $this->handlePasswordInput($this->crud->request);
		$this->crud->unsetValidation(); // validation has already been run

		$user_id = $this->crud->request->request->get('id');
		$user = BackpackUser::find($user_id);
		$name = $this->crud->request->request->get('name');

		$user_info = $user->userInfo;
		if(empty($user_info)) {
			$user_info = new UserInfo();
			$user_info->user_id = $user->id;
		}

		$user_info->name = $name;
		$user->userInfo()->save($user_info);

		$user_bmi = $user->userBmi;
		if(empty($user_bmi)) {
			$user_bmi = new UserBmi();
			$user_bmi->user_info_id = $user_info->id;
		}
		$user_bmi->save();

//		if(!empty($user) && !empty($name)) {
//			$user->name = $name;
//		}

		return $this->traitUpdate();
	}

	/**
	 * Handle password input fields.
	 */
	protected function handlePasswordInput($request)
	{
		// Remove fields not present on the user.
		$request->request->remove('password_confirmation');
		$request->request->remove('roles_show');
		$request->request->remove('permissions_show');

		// Encrypt password if specified.
		if ($request->input('password')) {
			$request->request->set('password', Hash::make($request->input('password')));
		} else {
			$request->request->remove('password');
		}

		return $request;
	}

	protected function addUserFields()
	{
		$this->crud->addFields([
			[
				'name'  => 'name',
				'label' => trans('backpack::permissionmanager.name'),
				'type'  => 'text',
			],
			[
				'name'  => 'email',
				'label' => trans('backpack::permissionmanager.email'),
				'type'  => 'email',
			],
			[
				'name'  => 'password',
				'label' => trans('backpack::permissionmanager.password'),
				'type'  => 'password',
			],
			[
				'name'  => 'password_confirmation',
				'label' => trans('backpack::permissionmanager.password_confirmation'),
				'type'  => 'password',
			],
			[
				'name'      => 'companies',
				'label'     => 'Bedrijf',
				'hint'      => '<small>Selecteer hier 1 bedrijf waar deze gebruiker aan gekoppeld dient te worden.</small>',
				'entity'    => 'companies',
				'attribute' => 'name',
				'type'      => 'select2_multiple',
				'model'     => 'App\Models\Company',
				'pivot'     => true,
			],
			[
				// two interconnected entities
				'label'             => trans('backpack::permissionmanager.user_role_permission'),
				'field_unique_name' => 'user_role_permission',
				'type'              => 'checklist_dependency',
				'name'              => ['roles', 'permissions'],
				'subfields'         => [
					'primary' => [
						'label'            => trans('backpack::permissionmanager.roles'),
						'name'             => 'roles', // the method that defines the relationship in your Model
						'entity'           => 'roles', // the method that defines the relationship in your Model
						'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
						'attribute'        => 'name', // foreign key attribute that is shown to user
						'model'            => config('permission.models.role'), // foreign key model
						'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
						'number_columns'   => 3, //can be 1,2,3,4,6
					],
					'secondary' => [
						'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
						'name'           => 'permissions', // the method that defines the relationship in your Model
						'entity'         => 'permissions', // the method that defines the relationship in your Model
						'entity_primary' => 'roles', // the method that defines the relationship in your Model
						'attribute'      => 'name', // foreign key attribute that is shown to user
						'model'          => config('permission.models.permission'), // foreign key model
						'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
						'number_columns' => 3, //can be 1,2,3,4,6
					],
				],
			],
		]);
	}
}
