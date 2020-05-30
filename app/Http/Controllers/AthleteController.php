<?php

namespace App\Http\Controllers;

use App\Athlete;
use Illuminate\Http\Request;

class AthleteController extends Controller
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
    public function store($id)
    {
        //
        $athlete = new Athlete();
        $athlete->user_id = $id;
        $athlete->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Athlete  $athlete
     * @return \Illuminate\Http\Response
     */
    public function show(Athlete $athlete)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Athlete  $athlete
     * @return \Illuminate\Http\Response
     */
    public function edit(Athlete $athlete)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Athlete  $athlete
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Athlete $athlete)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Athlete  $athlete
     * @return \Illuminate\Http\Response
     */
    public function destroy(Athlete $athlete)
    {
        //
    }


    public function toggleCurrentMonthPaymentStatus(Request $request)
    {
        $athlete = Athlete::find($request['athlete_id']);

        if ($athlete->monthPaid == '0') {
            $athlete->monthPaid = 1;
            $athlete->payment_date = strval(date('d/m/Y'));
        } else {
            $athlete->monthPaid = 0;
            $athlete->payment_date = null;
        }

        $athlete->save();
    }

    /**
     * Update athlete's subscription description and price 
     */

    public function updateSubscriptionOnAthlete(Request $request)
    {

        $athlete = Athlete::find($request['athlete_id']);
        $athlete->subscription_description = $request['subscription'] == null ? null : $request['subscription'];
        $athlete->subscription_price = $request['price'] == null ? null : doubleval($request['price']);
        $athlete->save();
        //return redirect()->route('profile.show', ["user" => $user]);

    }
}
