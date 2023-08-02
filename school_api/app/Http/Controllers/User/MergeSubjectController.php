<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\MergeSubject;
use Illuminate\Http\Request;
use App\Http\Requests\MergeSubjectFormRequest;
use Illuminate\Database\QueryException;

class MergeSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return MergeSubject::all();
    }

    public function store(Request $request)
    {

        $validationRules = [
            'mergesubject' => 'required|array',
            'mergesubject.*.subject_id' => 'required|integer',
            'mergesubject.*.session_id' => 'required|integer',
            'mergesubject.*.class_id' => 'required|integer',
            'mergesubject.*.merge_name' => 'required|integer',
        ];
    
        // Validate the request data
        $request->validate($validationRules);
        $mergesubjects = $request->input('mergesubject');
        try {
              foreach ($mergesubjects as $mergesubject) {
            // Assuming you have a model for mergesubjects and a corresponding database table
            // You can create a new mergesubject record for each item in the array
              MergeSubject::FirstOrCreate([
                'subject_id' => $mergesubject['subject_id'],
                'session_id' => $mergesubject['session_id'],
                'class_id' => $mergesubject['class_id'],
                'merge_name' => $mergesubject['merge_name'],
                'session_class' => $mergesubject['session_id'].'t'.$mergesubject['class_id'],
               
              ]);
           }

        // Optionally, you can return a response to the client
        return 'mergesubjects submitted successfully';
        
        } catch (QueryException $e) {
            // Handle the database error
            $errorMessage = "server eror: " . $e->getMessage();
            // Example: Returning a response to the user
            return response()->json(['message' => $errorMessage], 500);
        }
    }

   
   
    public function show(MergeSubject $mergeSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MergeSubject $mergeSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MergeSubject $mergeSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
       $id= MergeSubject::find($id);
      
       if(!$id){
        return "Id not found";
       }
       try{
         $id->delete();
         return 'Removed successfully';
       }
       catch(QueryException $e){
           response()->json(['message'=> 'error try again'.$e->getMessage(),500]);
       }
    }
}
