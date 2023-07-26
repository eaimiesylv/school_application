<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionForm extends FormRequest
{
   
    public function rules(): array
    {
        return [
            'year'=>'required|string|max:12',
            'term'=>'required|string',
          
        ];
    }
}
