<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Please enter your name',
            'email.required' => "Please enter your email",
            'email.email' => "Please enter a valid email",
            'email.unique' => "Email is already in use",
            'password' => 'Please enter a password'
        ];
    }
}
