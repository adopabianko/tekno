<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostCategoryRequest extends FormRequest
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
        switch($this->method()) {
            case 'POST':
                return [
                    'name' => ['required', Rule::unique('post_categories')
                        ->where('status', 1)
                    ],
                    'description' => 'required',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => ['required', Rule::unique('post_categories')
                        ->where('status', 1)
                        ->ignore($this->POST('name'),'name')],
                    'description' => 'required',
                ];
            default:break;
        }
    }
}
