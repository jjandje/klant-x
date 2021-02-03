<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
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
        	'title'     => 'required',
	        'image'     => 'required',
	        'content'   => 'required',
	        'duration'  => 'required|numeric',
//	        'articles'  => 'required',
//	        'recipes'   => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
	        'title.required'        => __('requests.required.title'),
	        'image.required'        => __('requests.required.image'),
	        'content.required'      => __('requests.required.content'),
	        'duration.required'     => __('requests.required.duration'),
	        'duration.numeric'      => __('requests.numeric.duration'),
	        'articles.required'     => __('requests.required.articles'),
	        'recipes.required'      => __('requests.required.recipes'),
        ];
    }
}
