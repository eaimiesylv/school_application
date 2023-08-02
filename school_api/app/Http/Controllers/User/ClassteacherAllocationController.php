<?php
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\ClassteacherAllocation;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ClassteacherAllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'ok';
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id'=>'required|integer',
            'class_id'=>'required|integer',
        ]);
        try{
            ClassteacherAllocation::FirstOrCreate($request->all());
            return 'Class teacher allocation succesful';
        }catch(QueryException $e){
           return  response()->json(['message'=>'Database error'],500);
        }
    }
       

    /**
     * Display the specified resource.
     */
    public function show(ClassteacherAllocation $classteacherAllocation)
    {
        //
    }

  

    
    public function destroy($id)
    {
        $id= ClassteacherAllocation::find($id);
        if(!$id){
            return 'No user found';
        }
        else{
            try{
                    $id->delete();
                    return response()->json(['Class Teacher Removed'],201);
            }catch(QueryException $e){

            }
        }
    }
}
