<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\SubjectForm;
use Illuminate\Database\QueryException;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Subject::with('klass')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubjectForm $request)
    {
        try {
            Subject::firstOrCreate($request->all());
            return "Subject has been successfully";
        } catch (QueryException $e) {
            // Handle the database error
            $errorMessage = "server eror: " . $e->getMessage();
            // Example: Returning a response to the user
            return response()->json(['message' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        //
    }
}
