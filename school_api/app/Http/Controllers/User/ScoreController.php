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
        try {
            Score::firstOrCreate($request->all());
            return "Subject has been successfully";
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
    public function show(Score $score)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Score $score)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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
