<?php

namespace App\Http\Controllers;

use App\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
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
    public function store(array $request)
    {
        // Let's create our training plan. 
        if (isset($request['author_id'])) {
            ActivityLog::create([
                'author_id' =>  $request['author_id'],
                'action' => isset($request['action']) ? $request['action'] : null,
                'entity_implied' => isset($request['entity_implied']) ? $request['entity_implied'] : null,
                'tab' => isset($request['tab']) ? $request['tab'] : null,
                'isGroup' => isset($request['isGroup']) ? $request['isGroup'] : false,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityLog $activityLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityLog $activityLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ActivityLog  $activityLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityLog $activityLog)
    {
        //
    }
}
