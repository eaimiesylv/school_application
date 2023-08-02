<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\ResumptionClosing;
use Illuminate\Http\Request;
use App\Http\Requests\ResumptionClosingFormRequest;
use Illuminate\Database\QueryException;

class ResumptionClosingController extends Controller
{
   
    public function index()
    {
        return 'ok';
    }

   
    public function store(ResumptionClosingFormRequest $request)
    {
       try{
        
          //ResumptionClosing::FirstorCreate($request->all());
          ResumptionClosing::updateOrCreate(['session_id' => $request->session_id], $request->all());

          return 'success';
       }catch(QueryException $e){
          return response()->json(['message'=>'Error'], 500);
       }
       
       
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $d=ResumptionClosing::where('session_id', $id)->first();
        return $d;
    }

   
    public function update(Request $request, ResumptionClosing $resumptionClosing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResumptionClosing $resumptionClosing)
    {
        //
    }
}
