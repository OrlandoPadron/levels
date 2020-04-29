<?php

namespace App\Http\Controllers;

use App\Macrocycle;
use Illuminate\Http\Request;

class MacrocycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Macrocycle::create([
            'title' => isset($request['title']) ? $request['title'] : null,
            'description' => isset($request['description']) ? $request['description'] : null,
            'athlete_associated' => $request['athlete_associated'],
            'status' => 'active',

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Macrocycle  $macrocycle
     * @return \Illuminate\Http\Response
     */
    public function show(Macrocycle $macrocycle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Macrocycle  $macrocycle
     * @return \Illuminate\Http\Response
     */
    public function edit(Macrocycle $macrocycle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Macrocycle  $macrocycle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Macrocycle $macrocycle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Macrocycle  $macrocycle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Macrocycle $macrocycle)
    {
        //
    }
}
