<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\SubjectAllocation;
use Illuminate\Http\Request;
use App\Http\Requests\SubjectAllocationFormRequest;
use Illuminate\Database\QueryException;

class SubjectAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'subject';
    }

    
    public function store(Request $request)
    {

        $validationRules = [
            'allocation' => 'required|array',
            'allocation.*.subject_id' => 'required|integer',
            'allocation.*.session_id' => 'required|integer',
            'allocation.*.class_id' => 'required|integer',
            'allocation.*.teacher_id' => 'required|integer',
        ];
    
        // Validate the request data
        $request->validate($validationRules);
        $allocations = $request->input('allocation');
        try {
              foreach ($allocations as $allocation) {
            // Assuming you have a model for allocations and a corresponding database table
            // You can create a new allocation record for each item in the array
              SubjectAllocation::FirstOrCreate([
                'subject_id' => $allocation['subject_id'],
                'session_id' => $allocation['session_id'],
                'class_id' => $allocation['class_id'],
                'teacher_id' => $allocation['teacher_id'],
                'session_class' => $allocation['session_id'].'t'.$allocation['class_id'],
               
              ]);
           }

        // Optionally, you can return a response to the client
        return 'Allocations submitted successfully';
        
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
    public function show($sessionid)
    {
        
      
      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectAllocation $subjectAllocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubjectAllocation $subjectAllocation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      
        $result=SubjectAllocation::find($id);
        if($result){
            $result->delete();
            return 'Allocation deleted successfully';
        }else{
            return 'Allocation not found, try again later';
        }
    }
}
