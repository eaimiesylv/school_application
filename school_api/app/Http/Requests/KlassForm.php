<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Classname; // Import the custom validation rule

class KlassForm extends FormRequest
{
    public function rules(): array
    {
        return [
            'class_name' => ['required', 'max:20','unique:klasses',new Classname], // Use the custom rule here
            'class_value' => 'required|integer'
        ];
    }
}
