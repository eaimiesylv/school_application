<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentFormRequest extends FormRequest
{
   
    public function rules(): array
    {
        return [
            'user_id'=>'required|integer',
            'regno'=>   '',
            'session_id'=>'required|integer',
            'class_id'=>'required|integer',
            'arm_id'=>''
        ];
    }
}
