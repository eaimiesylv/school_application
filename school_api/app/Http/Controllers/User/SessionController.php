<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\SessionForm;

use App\Models\Session;
use App\Models\Student;


use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB; // Import the DB facade


class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Session::select('id','year','term')->get();
    }

   
     // Get students with the highest session_id
        public function store(SessionForm $request)
        {
           
           $previousStdRecord=$this->getPreviousStudentRecord($request->term);
            try {
                    DB::beginTransaction(); // Start the transaction
                    // Create a new session
                    $latestSession = Session::firstOrCreate($request->all());
                    $latestSessionId = $latestSession->id;
                    //pass session id, previous student record and term
                    $studentsToInsert=$this->updateStudentClass_Session($latestSessionId,$previousStdRecord, $request->term);
                    Student::insert($studentsToInsert);
            
                    DB::commit(); // Commit the transaction if everything is successful
            
                    return "New sessions and associated students inserted successfully!";
                } catch (\Exception $e) {
                    DB::rollback(); // Rollback the transaction if an error occurs
                    return "Error: " . $e->getMessage();
                }
                
            
            
        }
        
    
    

    /**
     * Display the specified resource.
     */
    public function show($session)
    {
       
        if ($session == 'latest') {
           return Session::latest()->first();
        } else {
            return Session::find($session);
        }
    }

    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session)
    {
        //
    }
   public function session_assessment(){
      return Session::with('assessment')->get();
   }

   protected function getPreviousStudentRecord($term)
    {
        $query = Student::where('session_id', function ($query) {
            $query->select('session_id')
                ->from('students')
                ->orderBy('session_id', 'desc')
                ->limit(1);
        })->where('status', 'active');

        if ($term == "First Term") {
            $highestClassValue = \App\Models\Klass::max('class_value');
            $query->where('class_id', '<', $highestClassValue);
        }

        $studentsWithHighestSession = $query->get();
        return $studentsWithHighestSession;
    }

    protected function updateStudentClass_Session($latestSessionId,$studentsWithHighestSession,$term){
         // Clone and update students with the new session_id
         
         $studentsToInsert = [];
         foreach ($studentsWithHighestSession as $student) {
             $newStudentData = $student->toArray();
             $newStudentData['session_id'] = $latestSessionId;
             if($term == 'First Term'){
               $newStudentData['class_id'] = $student['class_id'] + 1;
             }
             $studentsToInsert[] = $newStudentData;
         }
         return $studentsToInsert;
    }

}
