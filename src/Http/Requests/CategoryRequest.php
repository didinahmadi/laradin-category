<?php

namespace Laradin\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest 
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
            'parent_id'     => 'nullable|numeric',
            'name'          => 'required|max:50',
            'description'   => 'nullable|max:255',
            'active'        => 'nullable'
        ];
    }
}