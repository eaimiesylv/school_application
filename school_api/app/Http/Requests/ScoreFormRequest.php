<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScoreFormRequest extends FormRequest
{
    
    public function rules(): array
    {
        return [
            'id'=>'',//this is the id of the scores useful for updateor create
            'user_id'=>'',
            'regno'=>'',
            'score'=>'required|integer',
            'assessment_id'=>'required|integer',
            'subject_id'=>'required|integer',
            'class_id'=>'required|integer',
            'session_id'=>'required|integer',
            'session_class'=>'', 
        ];
    }
}
