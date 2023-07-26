<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Classname implements Rule
{
    public function passes($attribute, $value)
    {
        return !preg_match('/\d$/', $value); // Check if the class_name does not end with a number
    }

    public function message()
    {
        return 'Class name cannot end with a number';
    }
}
