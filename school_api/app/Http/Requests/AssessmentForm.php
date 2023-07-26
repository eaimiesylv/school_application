<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssessmentForm extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'assessname'=>'required|string|max:12',
            'min'=>'required|integer',
            'max'=>'required|integer',
        ];
    }
}
