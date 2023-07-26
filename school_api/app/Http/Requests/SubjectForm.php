<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubjectForm extends FormRequest
{
    public function rules(): array
    {
        return [
            'subjects'=>'required|string|max:30',
            //'subject_label'=>'required|string|max:6',
            'class_id'=>'required|integer|max:20'
        
        ];
    }
}
