<?php

namespace Laradin\Category\Http\Requests;

use Laradin\Category\Http\Requests\CategoryRequest;
use Illuminate\Validation\Rule;

class CategoryDestroyRequest extends CategoryRequest 
{
    /**
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
            'action' => [
                'required',
                Rule::in(['destroy', 'disable'])
            ]
        ];
    }

}