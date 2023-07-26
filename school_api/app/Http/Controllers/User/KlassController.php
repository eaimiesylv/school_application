<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\KlassForm;

use App\Models\Klass;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class KlassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Klass::orderby('class_value')->get();
        return $classes;
        $classes->map(function ($class) {
            $class->class_name_with_value = $class->class_name_with_value;
            return $class;
        });

        // Return the data as JSON response
        return response()->json($classes);
    }


    public function store(KlassForm $request)
    {
        try {
            Klass::firstOrCreate([
                'class_name'=>$request->class_name ." ". $request->class_value,
                'class_value'=>$request->class_value
            ]);
            return "Class created successfully";
        } catch (QueryException $e) {
            // Handle the database error
            $errorMessage = "An error occurred while creating the class: " . $e->getMessage();
            // Example: Returning a response to the user
            return response()->json(['message' => $errorMessage], 500);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Klass $klass)
    {
        //
    }

    public function update(Request $request, Klass $klass)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Klass $klass)
    {
        //
    }
    public function klass_subject()
    {
        return Klass::select('id','class_name')->with('subjects')->get();
    }
    public function klass_subject_classid($id){
        return Klass::select('id','class_name')->where('id',$id)->with('subjects')->get();
    }
    public function klass_subject_allocation($sessionid){
        return Klass::select('id','class_name','class_value')->with([
            'subjectallocation' => function ($query) use ($sessionid) {
                $query->where('session_id', $sessionid);
            },
            'subjectallocation.subjects',
            'subjectallocation.users'
        ])->whereHas('subjectallocation', function ($query) use ($sessionid) {
            $query->where('session_id', $sessionid);
        })->get();
    }
    //handles selected merge subject
    public function klass_subject_merge($sessionid)
    {
        $classDetails = Klass::select('id', 'class_name', 'class_value')->with([
            'mergesubject' => function ($query) use ($sessionid) {
                $query->where('session_id', $sessionid);
            },
           // 'mergesubject.mergename:id,subjects',
            //'mergesubject.subjects:id,subjects',
           
        ])->whereHas('mergesubject', function ($query) use ($sessionid) {
            $query->where('session_id', $sessionid);
        })->get();
        return $classDetails;
        $result = [];
        $i=0;
        $klas = [];
        foreach ($classDetails as $class) {
            $classInfo = [
                'id' => $class->id,
                'class_name' => $class->class_name,
                'class_value' => $class->class_value,
            ];
            foreach ($class->mergesubject as $mergesubject) {
            }
            $klas[]=$classInfo;
        }
      //  return $classDetails;
        return $klas;
       /* foreach ($classDetails as $class) {
            $classInfo = [
                'id' => $class->id,
                'class_name' => $class->class_name,
                'class_value' => $class->class_value,
            ];
    
            $mergesubjects = [];
            foreach ($class->mergesubject as $mergesubject) {
                $mergename = $mergesubject->mergename->subjects;
                $mergesubjects["mergename"] = $mergename;

               // $mergesubjects["mergename"]=$mergename;
                $mergesubjects["subjects"][] = [
                    'id' => $mergesubject->id,
                    'subject' => $mergesubject->subjects->subjects,
                  
                ];
               
                    
            }
    
            $classInfo += $mergesubjects;
            $result['class_details'][] = $classInfo;
            $i++;
        }
    
        return $result;*/
    }
    

  public function klass_subject_allocation_teacher($sessionid)
{
    // Get the authenticated user's role and ID
    $role = Auth::user()->role;
    //return $role;
    $id = Auth::user()->id;
   
    return Klass::select('id', 'class_name', 'class_value')->with([
        'subjectallocation' => function ($query) use ($sessionid, $role, $id) {
            $query->where('session_id', $sessionid);
            // Allow role 3 (admin) to select everything without restrictions
            if ($role == 1) {
                $query->where('teacher_id', "$id");
            }
        },
        'subjectallocation.subjects',
        'subjectallocation.users'
    ])->whereHas('subjectallocation', function ($query) use ($sessionid, $id, $role) {
        $query->where('session_id', $sessionid);
        if ($role == 1) {
            $query->where('teacher_id', "$id");
        }
    })->get();
}


    public function klass_student($classid,$sessionid){
       
        $assessment = \App\Models\Assessment::select('assessname','max','min')->where('session_id', $sessionid)->get();
        $klass_std_detail=Klass::select('id','class_name','class_value')
        ->where('id',$classid)
        ->with(['students'=>function($query)use($sessionid){
            $query->where('session_id', $sessionid)
                   ->where("status", '=', "active");
        }
        
        ])
        ->with('students.user:id,first_name,last_name,passport')
        ->get();
        $klass_std_detail['assessment']=$assessment;
        return $klass_std_detail;

        
    }
}
