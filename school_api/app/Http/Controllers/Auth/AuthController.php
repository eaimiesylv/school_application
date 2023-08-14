<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth:api', ['except' => ['login','adminlogin']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
       
        
        try{
              /*  $emailRegno = $request->email_regno;
                if ($emailRegno && preg_match('/^[a-z]/', $emailRegno)) {
                    //return 'std reg';
                }
                else{
                   // return 'ad';
                }*/
                $fields=$request->validate([
                    'email_regno'=>'required',
                    'password'=>'required'
                ]);
                $credentials = request(['email_regno', 'password']);
                $user = User::where(function ($query) use ($request) {
                    $query->where('email', $request->input('email_regno'))
                          ->orWhere('id', $request->input('email_regno'));
                })->first();
            
                if(!$user || ! Hash::check($fields['password'],$user->password)){
                     return response(['message'=>"Wrong Credential"],401)->header('Content-Type', 'text/plain');
                } 
                $token = $user->createToken('api-token')->plainTextToken;
                $role=$user->role;
                return [$token,$user];
            }
        catch(Exception $e) {
                dd($e);
        }
    }
}
