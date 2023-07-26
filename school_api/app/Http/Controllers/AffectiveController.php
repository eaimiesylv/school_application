<?php

namespace App\Http\Controllers;

use App\Models\Affective;
use Illuminate\Http\Request;

class AffectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return 'test';
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Affective $affective)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Affective $affective)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Affective $affective)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Affective $affective)
    {
        //
    }
}
