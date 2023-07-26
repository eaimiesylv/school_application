<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name'=>'required|string|max:100',
            'last_name'=>'required|string|max:100',
            'dob'=>'required|date',
            'email'=>'required|unique:users',
            'password'=>'required|min:2|confirmed'
        ];
    }
}
