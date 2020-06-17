<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
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
        // Let's create our new group. 
        $group = Group::create([
            'title' => isset($request['title']) ? $request['title'] : null,
            'description' => isset($request['description']) ? $request['description'] : null,
            'created_by' => $request['created_by'],
            'status' => 'active',

        ]);
        $group->save();
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id, $tab)
    {
        $group = Group::find($id);
        return view('show-group', [
            'group' => $group,
            'tab' => $tab != null ? $tab : 'General',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (isset($request['group_id'])) {
            $group = Group::find($request['group_id']);
            $group->delete();
            return view('home');
        }
    }



    /**
     * Add members to a specific group. 
     */

    public function addMember(Request $request)
    {
        if (isset($request['athletesId'])) {
            $group = Group::find($request['group_id']);
            $groupMembers = (array) $group->athletes;
            foreach ($request['athletesId'] as $athleteId) {
                if (!in_array($athleteId, $groupMembers)) {
                    array_push($groupMembers, $athleteId);
                }
            }
            $group->athletes = $groupMembers;
            $group->save();
            return redirect()->route('group.show', ["group" => $group, 'tab' => 'miembros']);
        }
    }
    /**
     * Remove member from a specific group. 
     */

    public function removeMember(Request $request)
    {
        if (isset($request['user_id'])) {
            $athleteId = User::find($request['user_id'])->athlete->id;
            $group = Group::find($request['group_id']);
            $groupMembers = (array) $group->athletes;
            $group->athletes = array_values(array_diff($groupMembers, (array) $athleteId));
            $group->save();
        }
    }
}
