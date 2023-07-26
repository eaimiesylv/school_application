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

           return User::select('id','first_name','last_name','passport')->where([
                        ['role', 1],
                        ['status','active']
                        ])->get();
    }  
              
               
              
}

    
   

