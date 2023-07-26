<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectAllocationFormRequest extends FormRequest
{
    
   
    public function rules(): array
    {
        return [
           
            'teacher_id'=>'required|integer',
            'subject_id'=>'required|integer',
            'class_id'=>'required|integer',
            'session_id'=>'required|integer',
           
        ];
    }
}
