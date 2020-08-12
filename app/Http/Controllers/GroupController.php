<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Redirect;

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
        $threads = $group->threads;
        return view('show-group', [
            'group' => $group,
            'tab' => $tab != null ? $tab : 'General',
            'threads' => $threads,
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
        if (isset($request['group_id'])) {
            $group = Group::findOrFail($request['group_id']);
            $group->title = $request['title'] != null ? $request['title'] : 'Sin título';
            $group->description = $request['description'] != null ? $request['description'] : 'Sin descripción';


            //Handle group uploaded avatar
            if ($request->hasFile('group_avatar')) {
                $avatar = $request->file('group_avatar');
                $filename = time() . '.' . $avatar->getClientOriginalExtension();
                Image::make($avatar)->fit(500, 500)->save(public_path('uploads/group_avatars/' . $filename));


                // Delete previous avatar
                $previous_file = $group->group_image;
                if ($previous_file != 'default_group_avatar.jpg') {
                    if (file_exists('uploads/group_avatars/' . $previous_file)) {
                        unlink('uploads/group_avatars/' . $previous_file);
                    }
                }

                //Update avatar
                $group->group_image = $filename;
            }
            $group->save();
        }
        return Redirect::back();
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
            $group = Group::findOrFail($request['group_id']);

            //Unlink group image from app. 
            if ($group->group_image != 'default_group_avatar.jpg') {
                if (file_exists('uploads/group_avatars/' . $group->group_image)) {
                    unlink('uploads/group_avatars/' . $group->group_image);
                }
            }

            $group->delete();
            return redirect()->route('home');
        }
    }



    /**
     * Add members to a specific group. 
     */

    public function addMember(Request $request)
    {
        if (Auth::user()->isTrainer) {
            if (isset($request['usersId'])) {
                $group = Group::find($request['group_id']);
                $groupMembers = (array) $group->users;
                foreach ($request['usersId'] as $userId) {
                    if (!in_array($userId, $groupMembers)) {
                        array_push($groupMembers, $userId);
                    }
                }
                $group->users = $groupMembers;
                $group->save();
            }
        }
        return Redirect::back();
    }
    /**
     * Remove member from a specific group. 
     */

    public function removeMember(Request $request)
    {
        if (isset($request['user_id'])) {
            $userLoggedRole = getUserRole($request['group_id'], Auth::user()->id);
            $userDeletedRole = getUserRole($request['group_id'], $request['user_id']);
            if ($userLoggedRole == 'Propietario' || 'Administrador') {
                $group = Group::findOrFail($request['group_id']);
                $groupMembers = (array) $group->users;
                $group->users = array_values(array_diff($groupMembers, (array) $request['user_id']));

                if ($userDeletedRole == 'Administrador') {
                    $group->admins = array_values(array_diff((array)$group->admins, (array) $request['user_id']));
                }
                $group->save();
            }
        }
    }

    /**
     * Toggles the 'administrator' role on group member. 
     */

    public function toggleGroupAdmin(Request $request)
    {
        if (isset($request['group_id'])) {
            $group = Group::findOrFail($request['group_id']);
            $admins = (array) $group->admins;
            if (in_array($request['user_id'], $admins)) {
                $group->admins = array_values(array_diff($admins, (array) $request['user_id']));
            } else {
                array_push($admins, $request['user_id']);
                $group->admins = $admins;
            }
            $group->save();
        }
    }

    public function removeGroupImage(Request $request)
    {
        if (isset($request['group_id'])) {
            $group = Group::findOrFail($request['group_id']);
            // Delete previous avatar
            $previous_file = $group->group_image;
            if ($previous_file != 'default_group_avatar.jpg') {
                if (file_exists('uploads/avatars/group_avatars/' . $previous_file)) {
                    unlink('uploads/avatars/group_avatars/' . $previous_file);
                }
            }
            //Updates avatar
            $group->group_image = 'default_group_avatar.jpg';
            $group->save();
        }
        return Redirect::back();
    }
}
