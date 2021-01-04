<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
                    'category_id' => 'required',
                    'title' => ['required', Rule::unique('posts')
                        ->where('status', 1)
                    ],
                    'content' => 'required',
                    'cover' => 'required|image|mimes:jpeg,bmp,png|max:2048',
                ];
            case 'PUT':
            case 'PATCH':
                return [
                    'category_id' => 'required',
                    'title' => ['required', Rule::unique('posts')
                        ->where('status', 1)
                        ->ignore($this->POST('title'),'title')],
                    'content' => 'required',
                    'cover' => 'image|mimes:jpeg,bmp,png|max:2048',
                ];
            default:break;
        };
    }
}
