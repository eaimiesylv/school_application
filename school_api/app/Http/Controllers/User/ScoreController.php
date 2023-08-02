<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Score;
use Illuminate\Http\Request;
use App\Http\Requests\ScoreFormRequest;
use Illuminate\Database\QueryException;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'ok score';
    }

   
    public function store(ScoreFormRequest $request)
    {
       
        $min_max= \App\Models\Assessment::select('min','max')->where([ ['session_id', $request->session_id],['id', $request->assessment_id]])->first();
                                       
        $min= $min_max->min;  
        $max= $min_max->max;  
          if( $request->score > $max) {
            return response()->json(['message' =>"Maximum score for this assessment is  $max"], 500);
          } 
          if( $request->score < $min) {
            return response()->json(['message' =>"Minimum score for this assessment is  $min"], 500);
          }                                                      
                                                                      
                                                                   
        try {
            if(!$request->id){
                
                Score::FirstOrCreate($request->all());
                return "Score has been successfully entered";
            }
           
            Score::updateOrCreate(['id' => $request->id], $request->all());
            return "Score has been updated successfully";
        } catch (QueryException $e) {
            // Handle the database error
            $errorMessage = "Submission Error:******** " . $e->getMessage();
            // Example: Returning a response to the user
            return response()->json(['message' => $errorMessage], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
      return 'ok';
    }
    public function student_subject_score($subject_id,$assessment_id,$session_id)
    {
        return Score::select('id','user_id','score','subject_id','assessment_id')
                        ->where([
                                ['subject_id', $subject_id ],
                                ['assessment_id', $assessment_id ],
                                ['session_id', $session_id],
                                
                                ])->get();
    }
    public function student_result($class_id, $session_id){
        return Score::select('id','user_id','score','assessment_id','class_id','session_id','subject_id')
        ->with('term_session','assessment')
        ->where('class_id', $class_id)
        ->get();
    }
   
    public function update(Request $request, Score $score)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Score $score)
    {
        //
    }
}
