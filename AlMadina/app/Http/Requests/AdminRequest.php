<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:3'
        ];
    }

    public function messages()
    {
        return [
            //
            'name.required' =>'The Name Field Is Required22',
            'name.string' =>'The Name Field Must Be String',
            'name.min' =>'Minimum length of The Name Field Must Be 3',
            'email.required' =>'The Email Field Is Required',
            'email.email' =>'The Email Must be correct email',
            'email.unique' => 'The Email Must be unique',
            'password.required' => 'The Password Field Is Required',
        ];
    }
}
