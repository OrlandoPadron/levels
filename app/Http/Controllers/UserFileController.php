<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use App\UserFile;
use Illuminate\Http\Request;

class UserFileController extends Controller
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Check if the user is uploading a duplicate file 
        //(Training files skip this step). 
        $userFile = null;
        if ($request['method'] != 'trainingFile') {
            $userFile = UserFile::where([
                ['file_name', '=', $request['file_name']],
                ['extension', '=', $request['extension']],
                ['size', '=', $request['size']],
                ['owned_by', '=', $request['owned_by']]
            ])->first();
        }

        // Update that file's url. 
        if ($userFile != null) {
            $userFile->url = $request['url'];
            $userFile->save();
        } else {
            $userFile = UserFile::create([
                'file_name' => $request['file_name'] != null ? $request['file_name'] : 'Fichero sin nombre',
                'extension' => $request['extension'] != null ? $request['extension'] : "Fichero sin extensión",
                'size' => $request['size'],
                'url' => $request['url'],
                'owned_by' => $request['owned_by'],
            ]);
        }
        // Depending the type of file we're uploading.
        switch ($request['method']) {
            case 'userFile':
                // In case user is uploading a file into someone's profile.
                if ($request['shared_with'] != $request['owned_by']) {
                    $sharedWith = (array) $userFile->shared_with;
                    if (!in_array($request['shared_with'], $sharedWith)) {
                        array_push($sharedWith, $request['shared_with']);
                    }
                    $userFile->shared_with = $sharedWith;
                    $userFile->save();
                }
                break;
            case 'trainingFile':
                //Modify some values to represent a training plan file.
                $userFile->file_type = 1;
                $userFile->save();
                break;
            case 'groupFile':
                //Modify group files associated list 
                $group = Group::findOrFail($request['shared_with']);
                $files_array = (array) $group->files;
                if (!in_array($userFile->id, $files_array)) {
                    array_push($files_array, $userFile->id);
                    $group->files = $files_array;
                    $group->save();
                }
                //Modify some values to represent a group file.
                $userFile->file_type = 2;
                $userFile->save();

                break;
        }
        return $userFile->toArray();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserFile  $userFile
     * @return \Illuminate\Http\Response
     */
    public function show(UserFile $userFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserFile  $userFile
     * @return \Illuminate\Http\Response
     */
    public function edit(UserFile $userFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserFile  $userFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $method = $request['method'];
        $file = UserFile::findOrFail($request['fileId']);
        switch ($method) {
            case 'stopSharing':
                $sharedWithArray = (array) $file->shared_with;
                $delete = array($request['userId']);
                $file->shared_with = array_diff($sharedWithArray, $delete);
                $file->save();
                break;

            case 'shareFile':
                $sharedWithArray = (array) $file->shared_with;
                if (!in_array($request['userId'], $sharedWithArray)) {
                    array_push($sharedWithArray, $request['userId']);
                }
                $file->shared_with = $sharedWithArray;
                $file->save();
                break;

            case 'shareFileWithGroup':
                $group = Group::findOrFail($request['groupId']);
                $groupFiles = (array) $group->files;
                if (!in_array($file->id, $groupFiles)) {
                    array_push($groupFiles, $file->id);
                }
                $group->files = $groupFiles;
                $group->save();

                break;

            case 'groupStopSharing':
                $group = Group::findOrFail($request['groupId']);
                $group->files = array_diff($group->files, (array) $file->id);;
                $group->save();

                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserFile  $userFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        UserFile::find($request['fileId'])->delete();
    }
}
