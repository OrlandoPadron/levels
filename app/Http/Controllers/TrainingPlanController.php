<?php

namespace App\Http\Controllers;

use App\Athlete;
use App\Macrocycle;
use App\Mesocycle;
use App\Microcycle;
use App\Session;
use App\TrainingPlan;
use Illuminate\Http\Request;

class TrainingPlanController extends Controller
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
        // Let's create our training plan. 
        $trainingPlan = TrainingPlan::create([
            'title' => isset($request['title']) ? $request['title'] : null,
            'description' => isset($request['description']) ? $request['description'] : null,
            'athlete_associated' => $request['athlete_associated'],
            'status' => 'active',

        ]);

        // Let's add it the macrocycles. 
        for ($i = 1; $i <= $request['num_macrocycles']; $i++) {
            $title = "Macrociclo #" . strval($i);
            $macrocycle = Macrocycle::create([
                'title' => $title,
                'tplan_associated' => $trainingPlan->id,
            ]);
            // Add mesocycles to macrocycles
            for ($j = 1; $j <= $request['num_mesocycles']; $j++) {
                $mesocycle = Mesocycle::create([
                    'macrocycle_associated' => $macrocycle->id,
                ]);
                // Add microcycles to mesocycles
                for ($k = 1; $k <= $request['num_microcycles']; $k++) {
                    $title = 'M' . strval($j) . ' | Semana Nº ' . strval($k);
                    $microcycle = Microcycle::create([
                        'title' => $title,
                        'mesocycle_associated' => $mesocycle->id,
                    ]);
                    // Add sessions to microcycle
                    // for ($l = 1; $l <= $request['num_sessions']; $l++) {
                    //     Session::create([
                    //         'microcycle_associated' => $microcycle->id,
                    //     ]);
                    // }
                }
            }
        }


        $athlete = Athlete::find($request['athlete_associated']);
        $id_user = $athlete->user->id;
        //dump($id_user);
        return redirect()->route('profile.show', ['user' => $id_user, 'tab' => 'plan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TrainingPlan  $trainingPlan
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingPlan $trainingPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TrainingPlan  $trainingPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingPlan $trainingPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TrainingPlan  $trainingPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        switch ($request['method']) {
            case 'addFileToPlan':
                //Adds files to a specific training plan
                $plan = TrainingPlan::findOrFail($request['planId']);
                $files = (array) $plan->files_associated;
                if (!in_array($request['fileId'], $files)) {
                    array_push($files, $request['fileId']);
                    $plan->files_associated = $files;
                    $plan->save();
                }
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TrainingPlan  $trainingPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $plan = TrainingPlan::findOrFail($request['id_plan']);
        $plan->delete();
        return redirect()->route('profile.show', ['user' => $request['user_id'], 'tab' => 'plan']);
    }
}
