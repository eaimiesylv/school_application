<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserForm extends FormRequest
{
    
    
    public function rules(): array
    {
        
        return [
            'first_name'=>'required|string|max:100|min:2',
            'last_name'=>'required|string|max:100|min:2',
            'dob'=>'',
            'sex'=>'required|string',
            'session_id'=>'required|integer',
            'email_regno'=>'required|unique:users|email',
            'password'=>'required|min:2',
            'category'=>'required',
            //'passport'=>'required|image'
        ];
    }
}
