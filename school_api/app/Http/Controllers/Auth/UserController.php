<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserForm;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use App\HelperClass\Imageupload;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Student;
class UserController extends Controller
{
  public function index(){

    return 'ok';
  }
    

    public function store(UserForm $request)
    {
        try {
            $path = "no.jpg";
            if ($request->hasFile('passport')) {
                $path = \App::make(Imageupload::class, [$request->passport, 'passport']);
                $path = $path['storage_path'];
            }
    
            // Start the database transaction
            DB::beginTransaction();
    
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'sex' => $request->sex,
                'dob' => $request->dob,
                'passport' => $path,
                'class_id' => $request->class_id,
                'session_id' => $request->session_id,
                'role' => $request->category,
                'password' => Hash::make($request->password),
            ]);
            //role 0 is for student
            if($user->role == 0){
                $student = Student::create([
                    'user_id' => $user->id,
                    //'regno' => '',
                    'session_id' => $user->session_id,
                    'class_id' => $user->class_id,
                    // 'arm_id' => '',
                ]);
            }
    
            // Commit the transaction if both records are created successfully
            DB::commit();
    
            // Return the response or success message
            return 'registration successful';
            // You can return any response or success message here
        } catch (QueryException $e) {
            // Handle the database error
    
            // Rollback the transaction if an exception occurs
            DB::rollback();
    
            $errorMessage = "An error occurred while creating the class: " . $e->getMessage();
    
            // Example: Returning a response to the user
            return response()->json(['message' => $errorMessage], 500);
        }
    }
    
              
    public function allteacher(){

           return User::select('id','first_name','last_name','passport','status')->where([
                        ['role', 1],
                        ['status','active']
                        ])->get();
    } 
    
    
    public function student_result($class_id, $session_id){
       
       $users =$this->Users_score($class_id, $session_id);
       return $users;
        //subject total for each subject, return total score obtained by each student
        $subject_total=$this->subject_total($users);
        //Worked on each users subject scores
        $result = [];
        foreach ($users as $user) {
            //group each user subject. this group the scores relationship
            $userScores = $user->scores->groupBy('subject.subjects');
           
            $result[$user->first_name." ".$user->last_name."#".$user->id]
                     = $this->process_each_user_score($userScores, $subject_total);
        }     
        return $result;


        ///

    }
    //List of helper functions
    protected function Users_score($class_id, $session_id){
        //
        $filteredSubjects = \App\Models\MergeSubject::select('subject_id')->where( [['session_id', $session_id],['class_id', $class_id]])->pluck('subject_id');
       
       return User::select('id', 'first_name', 'last_name', 'sex', 'passport')
    ->with('scores:id,subject_id,assessment_id,user_id,score,class_id,session_id', 'scores.subject:id,subjects', 'scores.assessment')
    ->whereHas('scores', function ($query) use ($session_id, $class_id, $filteredSubjects) {
        $query->where([
            ['scores.session_id', $session_id],
            ['scores.class_id', $class_id]
        ])->leftJoin('merge_subjects', 'scores.subject_id', '=', 'merge_subjects.subject_id')
        ->whereNull('merge_subjects.subject_id');
    })
    ->get();
    }
      protected function subject_total($users){
         // Initialize an empty array to store the total assessment scores
         $totalAssessmentScores = [];

         // Iterate through each user and calculate total assessment scores for each subject
         foreach ($users as $user) {
             foreach ($user->scores as $score) {
                 $subjectName = $score->subject->subjects;
                 $userName = "{$user->first_name} {$user->last_name}#{$user->id}";

                 // If the subject does not exist in the totalAssessmentScores array, create it
                 if (!isset($totalAssessmentScores[$subjectName])) {
                     $totalAssessmentScores[$subjectName] = [];
                 }

                 // If the user does not exist in the totalAssessmentScores for the subject, create it
                 if (!isset($totalAssessmentScores[$subjectName][$userName])) {
                     $totalAssessmentScores[$subjectName][$userName] = 0;
                 }

                 // Add the current score to the total score for the subject and user
                 $totalAssessmentScores[$subjectName][$userName] += $score->score;
             }
         }
         return $totalAssessmentScores;
         /**This is what $subject_total
         * English: {
         * "Lavonne Harris#169": 55,
         * "Bonnie Baumbach#170": 70
         * },
         *  Mathematics: {
         * "Lavonne Harris#169": 45,
         * "Bonnie Baumbach#170": 80
         * },
         */
      }
      protected function process_each_user_score($userScores, $subject_total){
         $formattedScores = [];
        
        foreach ($userScores as $subjectName => $scores) {
            $totalScore = 0;
            //$onlyScore contains only scores of all std in the selected subject
             $allStdScore=$subject_total[$subjectName];
             $onlyScore =[];
            foreach($allStdScore as $key=>$value){
               $onlyScore[]=$value;
            }
            rsort($onlyScore);
            
            $formattedAssessments = [];
            foreach ($scores as $score) {
                $formattedAssessments[$score->assessment->assessname] = $score->score;
                $totalScore += $score->score;
                $subject=$score->subject->subjects;
            }
            $formattedAssessments['Total'] = $totalScore;
            //get position
            if(is_array($onlyScore)){
                    $position = array_search($totalScore, $onlyScore);
                    $formattedAssessments['Position']=$position + 1;
                    //get  score highest
                    $formattedAssessments['Class Highest']=$onlyScore[0];	
                    //get avg
                    $avg= array_sum($onlyScore)/count($onlyScore);
                    $formattedAssessments['Class Average']=Round($avg,2);
                    //
                    
                    $formattedAssessments['Grade']=$this->grade($totalScore)['grade'];	
                    $formattedAssessments['Remark']=$this->grade($totalScore)['remark'];	
                    $formattedScores[$subjectName] = $formattedAssessments;
            }
        }
        return $formattedScores;
      } 
      protected function grade($score){

         $coment=[];
         $grad="";
         $rem="";
       if($score>69){
           $grad="A";
          $rem="Distinction";
       }
       else if($score>49){
            $grad="C";
          $rem="Credit";
       }
       else if($score>39){
            $grad="P";
          $rem="Pass";
       }
        else if($score<40){
            $grad="F";
          $rem="Fail";
       }
       else{
           $grad=" ";
          $rem=" ";
       }
       $coment['grade']=$grad;
       $coment['remark']=$rem;
       return $coment;
       
    }
             
               
              
}

    
   

