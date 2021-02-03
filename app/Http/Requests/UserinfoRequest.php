<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserinfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
	    return [
		    'name'      => 'required',
		    'age'       => 'required|numeric|min:18|max:120',
		    'gender'    => 'required',
		    'length'    => 'required|numeric|min:100|max:230',
		    'weight'    => 'required|numeric|min:30|max:300',
	    ];
    }

	public function attributes() {
		return [
			'name'          => 'Naam',
			'age'           => 'Leeftijd',
			'gender'        => 'Geslacht',
			'length'        => 'Lengte',
			'weight'        => 'Gewicht',
		];
	}

	public function messages() {
		return [
			'name.required'         => __('requests.required.name'),
			'age.required'          => __('requests.required.age'),
			'age.numeric'           => __('requests.numeric.age'),
			'age.min'               => 'De leeftijd moet minimaal :min zijn',
			'age.max'               => 'De leeftijd mag maximaal :max zijn',
			'gender.required'       => __('requests.required.gender'),
			'length.required'       => __('requests.required.length'),
			'length.numeric'        => __('requests.numeric.length'),
			'length.min'            => 'De lengte moet minimaal :min zijn',
			'length.max'            => 'De lengte mag maximaal :max zijn',
			'weight.required'       => __('requests.required.weight'),
			'weight.numeric'        => __('requests.numeric.weight'),
			'weight.min'            => 'Het gewicht moet minimaal :min zijn',
			'weight.max'            => 'Het gewicht mag maximaal :max zijn',
		];
	}
}
