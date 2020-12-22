<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TagRequest extends FormRequest
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
                    'name' => 'required|unique:tags',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'name' => ['required', Rule::unique('tags')->ignore($this->POST('name'),'name')],
                ];
            default:break;
        };
    }
}
