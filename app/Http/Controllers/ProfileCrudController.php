<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests\UserinfoRequest;
use App\Models\UserBmi;
use App\Models\UserInfo;
use Backpack\CRUD\app\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Application;

/**
 * Class ProfileCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProfileCrudController extends CrudController
{
	use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
	use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation { show as traitShow; }

    public function setup()
    {
	    $this->crud->setModel( 'App\Models\UserInfo' );
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/profile');
        $this->crud->setEntityNameStrings('profile', 'profiles');
    }

    protected function setupShowRoutes($segment, $routeName, $controller) {
    	\Route::get($segment, [
    		'as'        => 'backpack.'.$routeName.'.show',
		    'uses'      => $controller.'@show',
		    'operation' => 'show',
	    ]);
    }

    // showAccount
    public function show() {
		$user = $this->guard()->user();
        $this->data['title'] = __('account.profile');
        $this->data['user'] = $user;
        $this->data['user_info'] = $user->userInfo;
        $this->data['user_bmi'] = $user->userBmi;
        $this->data['user_goals'] = $user->activeGoals();
        $this->data['goals'] = $user->inactiveGoals();
        $this->data['favorite_recipes'] = $user->favoriteRecipes;
        $this->data['favorite_articles'] = $user->favoriteArticles;
        return view(backpack_view('profile.show'), $this->data);
    }

    // editAccountForm
//	public function edit($id) {
////    	$id = $this->guard()->user()->userInfo->id;
//		$this->data['entry'] = $this->crud->getEntry($id);
////		$this->data['crud'] = $this->crud;
//		$this->data['saveAction'] = $this->crud->getSaveAction();
////		$this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;
//
//		$this->data['title'] = 'Profiel aanpassen';
////		$this->data['user'] = $this->guard()->user();
////		$this->data['user_info'] = $this->guard()->user()->userInfo;
//		$this->data['crud'] = $this->crud;
//
//		$this->data['id'] = $id;
////    	dd( $this->crud);
//		$this->crud->setFromDb();
//		$this->crud->removeField('user_id');
//		$this->crud->removeField('image');
//		$this->crud->addField([
//			'label'     => 'Profiel foto',
//			'name'      => 'image',
//			'type'      => 'image',
//			'upload'    => true,
//			'prefix'    => 'uploads/',
////			'value'     => $this->guard()->user()->userInfo->image,
//		]);
//
//		// load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
//		return view($this->crud->getEditView(), $this->data);
//
//
////		return view(backpack_view('profile.edit'), $this->data);
//    }

    // storeAccountForm
	public function update( UserinfoRequest $request ) {
		$user = $this->guard()->user();
		$user_info = $user->userInfo;
		if(empty($user_info)) {
			$user_info = new UserInfo();
			$user_info->user_id = $user->id;
		}
		// set rest of user info
		$user_info->image = $request->get('image');
		$user_info->name = $request->get('name');
		$user_info->age = $request->get('age');
		$user_info->gender = $request->get('gender');
		$user_info->length = (float)$request->get('length');
		$user_info->weight = (float)$request->get('weight');
		$user_info->target_weight = (float)$request->get('target_weight');
		$user_info->about = $request->get('about') ?? null;
		// save user info
		$user->userInfo()->save($user_info);

		$user_bmi = $user->userBmi;
		if(empty($user_bmi)) {
			$user_bmi = new UserBmi();
			$user_bmi->user_info_id = $user_info->id;
		}
		$user_bmi->bmi = ((float)$user_info->weight / (((float)$user_info->length / 100) * ((float)$user_info->length / 100)));
		$result = $user_bmi->save();

		if ($result) {
			Alert::success(trans('backpack::crud.update_success'))->flash();
		} else {
			Alert::error(trans('backpack::base.error_saving'))->flash();
		}

		return redirect()->route('backpack.profile.show');
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(UserinfoRequest::class);

	    $this->crud->addField([
	    	'label'     => 'Naam',
		    'name'      => 'name',
		    'type'      => 'text',
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Geslacht',
		    'name'      => 'gender',
		    'type'      => 'select_from_array',
		    'options'   => ['male' => 'Man', 'female' => 'Vrouw'],
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Leeftijd',
		    'name'      => 'age',
		    'type'      => 'number',
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Lengte',
		    'name'      => 'length',
		    'type'      => 'number',
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Gewicht',
		    'name'      => 'weight',
		    'type'      => 'number',
	    ]);
	    $this->crud->addField([
	    	'label'     => 'Over',
		    'name'      => 'about',
		    'type'      => 'textarea',
	    ]);
    }

	protected function setupUpdateOperation()
	{
		$this->setupCreateOperation();
		$this->crud->addField([
			'label'     => 'Streefgewicht.',
			'name'      => 'target_weight',
			'type'      => 'number',
		]);
		$this->crud->addField([
			'label'     => 'Profiel foto',
			'name'      => 'image',
			'type'      => 'image',
			'upload'    => true,
			'crop'      => true,
			'aspect_ratio'  => 1,
		])->beforeField('name');
	}

    // getAccountInfoForm
	public function create() {
		$this->data['title'] = 'Profiel aanmaken';
		$this->data['user'] = $this->guard()->user();
		$this->data['user_info'] = $this->guard()->user()->userInfo ?? null;

		return view(backpack_view('profile.create'), $this->data);
    }

	// postAccountInfoForm
	public function store( UserinfoRequest $request ) {
		$user = $this->guard()->user();
		$user_info = $user->userInfo;
		if(empty($user_info)) {
			$user_info = new UserInfo();
			$user_info->user_id = $user->id;
		}
		// set rest of user info
		$user_info->name = $request->get('name');
		$user_info->age = $request->get('age');
		$user_info->gender = $request->get('gender');
		$user_info->length = (float)$request->get('length');
		$user_info->weight = (float)$request->get('weight');
		// save user info
		$user->userInfo()->save($user_info);

		$user_bmi = $user->userBmi;
		if(empty($user_bmi)) {
			$user_bmi = new UserBmi();
			$user_bmi->user_info_id = $user_info->id;
		}
		$user_bmi->bmi = ((float)$user_info->weight / (((float)$user_info->length / 100) * ((float)$user_info->length / 100)));
		$result = $user_bmi->save();

		if ($result) {
			Alert::success(trans('backpack::base.account_updated'))->flash();
		} else {
			Alert::error(trans('backpack::base.error_saving'))->flash();
		}

		$user->active = 1;
		$user->save();

		return redirect()->route('backpack.profile.show');
    }

    // getChangePassWordForm
	public function editPassword(  ) {
		$this->data['title'] = trans('backpack::base.my_account');
		$this->data['user'] = $this->guard()->user();

		return view(backpack_view('profile.password'), $this->data);
    }

    // postChangePasswordForm
	public function postPassword( ChangePasswordRequest $request ) {
		$user = $this->guard()->user();
		$user->password = Hash::make($request->new_password);

		if ($user->save()) {
			Alert::success(trans('backpack::base.account_updated'))->flash();
		} else {
			Alert::error(trans('backpack::base.error_saving'))->flash();
		}

		return redirect()->back();
    }

	/**
	 * Get the guard to be used for account manipulation.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return backpack_auth();
	}
}
