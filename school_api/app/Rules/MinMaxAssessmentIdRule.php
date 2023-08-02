<?php
// app/Rules/MinMaxAssessmentIdRule.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MinMaxAssessmentIdRule implements Rule
{
    protected $sessionId;
    protected $minAssessmentId;
    protected $maxAssessmentId;

    public function __construct($sessionId)
    {
        $this->sessionId = $sessionId;
        $this->loadMinMaxAssessmentIds();
    }

    protected function loadMinMaxAssessmentIds()
    {
        $minMaxValues = DB::table('assessments')
            ->where('session_id', $this->sessionId)
            ->selectRaw('MIN(id) as min_id, MAX(id) as max_id')
            ->first();

        $this->minAssessmentId = $minMaxValues->min_id;
        $this->maxAssessmentId = $minMaxValues->max_id;
    }

    public function passes($attribute, $value)
    {
        return $value >= $this->minAssessmentId && $value <= $this->maxAssessmentId;
    }

    public function message()
    {
        return "The :attribute must be between {$this->minAssessmentId} and {$this->maxAssessmentId} for the given session.";
    }
}
