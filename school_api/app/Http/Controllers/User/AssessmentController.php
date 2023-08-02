<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Http\Requests\AssessmentForm;
use Illuminate\Database\QueryException;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Assessment::all();
    }

   
    public function store(AssessmentForm $request)
    {
        try{
            Assessment::FirstOrCreate($request->all());
            return 'Assessment has been successfully created';
        }
        catch(QueryExeception $e){
            $msg='Server error'.$e->getMessage();
            return response()->json(['message'=>$msg],500);
        }   
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return Assessment::where('session_id', $id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assessment $assessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assessment $assessment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assessment $assessment)
    {
        //
    }
}
