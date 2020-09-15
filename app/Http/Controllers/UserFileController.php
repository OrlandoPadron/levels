<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use App\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFileController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


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
                'file_name' => $request['file_name'] != null ? $request['file_name'] : 'Archivo sin nombre',
                'extension' => $request['extension'] != null ? $request['extension'] : "Archivo sin extensión",
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
                    $fileName = $userFile->file_name . '.' . $userFile->extension;
                    $log = array(
                        'author_id' => Auth::user()->id,
                        'action' => 'subido el archivo <span style="color:#6013bb;">\'' . $fileName . '\'</span>',
                        'tab' => 'archivos',
                        'entity_implied' => $request['shared_with']
                    );
                    saveActivityLog($log);
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
                // $userFile->file_type = 2;
                $userFile->save();
                $fileName = $userFile->file_name . '.' . $userFile->extension;
                $log = array(
                    'author_id' => Auth::user()->id,
                    'action' => 'subido el archivo <span style="color:#6013bb;">\'' . $fileName . '\'</span>',
                    'tab' => 'archivos',
                    'entity_implied' => $group->id,
                    'isGroup' => true
                );
                saveActivityLog($log);

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
                $fileName = $file->file_name . '.' . $file->extension;
                $log = array(
                    'author_id' => Auth::user()->id,
                    'action' => 'compartido el archivo <span style="color:#6013bb;">\'' . $fileName . '\'</span>',
                    'tab' => 'archivos',
                    'entity_implied' => $request['userId']
                );
                saveActivityLog($log);

                break;

            case 'shareFileWithGroup':
                $group = Group::findOrFail($request['groupId']);
                $groupFiles = (array) $group->files;
                if (!in_array($file->id, $groupFiles)) {
                    array_push($groupFiles, $file->id);
                }
                $group->files = $groupFiles;
                $group->save();
                $fileName = $file->file_name . '.' . $file->extension;
                $log = array(
                    'author_id' => Auth::user()->id,
                    'action' => 'compartido el archivo <span style="color:#6013bb;">\'' . $fileName . '\'</span>',
                    'tab' => 'archivos',
                    'entity_implied' => $group->id,
                    'isGroup' => true,
                );
                saveActivityLog($log);

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

        //Let's check if the file is in any group. 
        $fileId = $request['fileId'];
        $groups = getUserGroups();
        foreach ($groups as $group) {
            $groupFiles = (array) $group->files;
            if (in_array($fileId, $groupFiles)) {
                $group->files = array_values(array_diff($groupFiles, (array) $fileId));
                $group->save();
            }
        }
    }
}
