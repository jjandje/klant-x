<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests\UserinfoRequest;
use App\Models\UserBmi;
use App\Models\UserInfo;
use Backpack\CRUD\app\Http\Requests\ChangePasswordRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

	/**
	 * Show the user profile with related account info
	 * Related account info like: name, profile photo, age, length, gender, weight, BMI, targets, favorited recipes and favorited articles
	 */
	public function showAccount() {
		$this->data['title'] = 'Profiel';
		$this->data['user'] = $this->guard()->user();
		$this->data['user_info'] = $this->guard()->user()->userInfo;
		$this->data['user_bmi'] = $this->guard()->user()->userBmi;
		return view(backpack_view('profile.show'), $this->data);
    }

	/**
	 * Allows the user to edit it's account info
	 * Info including: name, profile photo, age, length, gender and weight
	 */
	public function editAccountForm() {
		$this->data['title'] = 'Profiel aanpassen';
		$this->data['user'] = $this->guard()->user();
		$this->data['user_info'] = $this->guard()->user()->userInfo;
		return view(backpack_view('profile.edit'), $this->data);
    }

	public function storeAccountForm( UserinfoRequest $request ) {
		$user = $this->guard()->user();
//		$user->image = $request->get('image');
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
		$user_info->target_weight_min = $request->get('target_weight_min');
		$user_info->target_weight_max = $request->get('target_weight_max');
		$user_info->save();
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

		return redirect()->route('backpack.account');
    }

    /**
     * Prompts a user to set it's basic info
     * Basic info like: Name, age, gender, length and weight
     */
    public function getAccountInfoForm()
    {
        $this->data['title'] = 'Profiel aanmaken';
        $this->data['user'] = $this->guard()->user();
	    $this->data['user_info'] = $this->guard()->user()->userInfo ? $this->guard()->user()->userInfo : null;

        return view(backpack_view('profile.create'), $this->data);
    }

    /**
     * Save the modified personal information for a user.
     */
    public function postAccountInfoForm(UserinfoRequest $request)
    {
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

        return redirect()->route('backpack.account');
    }

	public function getChangePassWordForm() {
		$this->data['title'] = trans('backpack::base.my_account');
		$this->data['user'] = $this->guard()->user();

		return view(backpack_view('profile.password'), $this->data);
    }

    /**
     * Save the new password for a user.
     */
    public function postChangePasswordForm(ChangePasswordRequest $request)
    {
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
