<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResumptionClosingFormRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'resumption'=>'required|date',
            'closing'=>'required|date',
            'session_id'=>'required|integer'
        ];
    }
}
