<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenditureData extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
             'monthly_target' => 'required|numeric',
            'date' => 'required|date',
            'today_expense' => 'required|string|max:300',
            'amount' => 'required|numeric',
        ];
    }
}
