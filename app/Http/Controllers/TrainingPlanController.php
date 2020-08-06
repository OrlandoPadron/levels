<?php

namespace App\Http\Controllers;

use App\Athlete;
use App\Macrocycle;
use App\Mesocycle;
use App\Microcycle;
use App\Session;
use App\TrainingPlan;
use App\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
            'start_date' => isset($request['startDate']) ? $request['startDate'] : null,
            'end_date' => isset($request['endDate']) ? $request['endDate'] : null,

        ]);




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
            case 'removeFileFromPlan':
                //Removes file from a specific training plan 
                $plan = TrainingPlan::findOrFail($request['planId']);
                $files = (array) $plan->files_associated;
                if (in_array($request['fileId'], $files)) {
                    $plan->files_associated = array_diff($files, (array) $request['fileId']);
                    $plan->save();
                }
                break;

            case 'updateFile':
                $file = UserFile::findOrFail($request['fileId']);
                $file->size = $request['size'];
                $file->url = $request['url'];
                $file->save();
                break;

            case 'updatePlan':
                $plan = TrainingPlan::findOrFail($request['id_plan']);
                //Updating plan values
                $plan->title = $request['title'];
                $plan->description = $request['description'];
                $plan->start_date = $request['startDate'];
                $plan->end_date = $request['endDate'];

                $plan->save();
                return Redirect::back();

            case 'togglePlanStatus':
                $plan = TrainingPlan::findOrFail($request['id_plan']);
                $plan->status = $plan->status == 'active' ? 'finished' : 'active';
                $plan->save();

                return Redirect::back();
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
