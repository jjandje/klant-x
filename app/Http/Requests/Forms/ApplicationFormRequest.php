<?php

namespace App\Http\Requests\Forms;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'              => 'required',
	        'company_name'      => 'required|unique:companies,name|unique:applications,companyname',
	        'phonenumber'       => 'required|numeric|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
	        'email'             => 'required|unique:users|unique:applications,emailaddress',
        ];
    }

	public function attributes() {
		return [
			'name'          => 'Naam',
			'company_name'  => 'Bedrijfsnaam',
			'phonenumber'   => 'Telefoonnummer',
			'email'         => 'E-mailadres',
		];
    }

	public function messages() {
		return [
			'name.required'         => __('requests.required.name'),
			'email.unique'          => __('requests.unique.email'),
			'company_name.required' => __('requests.required.company_name'),
			'company_name.unique'   => __('requests.unique.company_name'),
			'phonenumber.required'  => __('requests.required.phonenumber'),
			'phonenumber.numeric'   => __('requests.numeric.phonenumber'),
			'email.required'        => __('requests.required.email'),
		];
    }
}
