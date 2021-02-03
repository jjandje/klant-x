<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
        	'title'         => 'required',
	        'image'         => 'required',
	        'content'       => 'required',
	        'preparation'   => 'required',
	        'ingredients'   => 'required',
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
            'title'         => 'Titel',
	        'image'         => 'Afbeelding',
	        'content'       => 'Content',
	        'preparation'   => 'Bereiding',
	        'ingredients'   => 'Ingrediënten',
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
	        'preparation.required'  => __('requests.required.preparation'),
	        'ingredients.required'  => __('requests.required.ingredients'),
        ];
    }
}
