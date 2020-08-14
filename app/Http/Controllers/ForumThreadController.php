<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use App\ForumThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ForumThreadController extends Controller
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
        if (isset($request['user_associated'])) {
            $thread = ForumThread::create([
                'title' => $request['title'] != null ? $request['title'] : 'Hilo sin título',
                'description' => $request['description'] != null ? $request['description'] : "<p>Este hilo no tiene contenido.</p>",
                'author' => $request['created_by'],
                'user_associated' => $request['user_associated'],
            ]);

            $user = User::find($request['user_associated']);

            // Log storage. 
            $log = array(
                'author_id' => Auth::user()->id,
                'action' => 'creado el hilo <span style="color:#6013bb;">\'' . $request['title'] . '\'</span>',
                'tab' => 'foro',
                'entity_implied' => $request['user_associated']
            );
            saveActivityLog($log);
            // End log storage

            //Update notifications_json to prevent system to show this new thread as 'not visited'.
            $json_decode = json_decode(Auth::user()->notifications_json, true);
            $json_decode['forum'][$thread->id]['lastVisit'] = date("Y-m-d H:i:s", time());
            Auth::user()->notifications_json = json_encode($json_decode);
            Auth::user()->save();
            //End update to notifications_json

            if (Auth::user()->isTrainer) {
                return redirect()->route('profile.show', ['user' => $user, 'tab' => 'foro']);
            } else {
                return redirect()->route('athlete.home', 'foro');
            }
        } else {
            $thread = ForumThread::create([
                'title' => $request['title'] != null ? $request['title'] : 'Hilo sin título',
                'description' => $request['description'] != null ? $request['description'] : "<p>Este hilo no tiene contenido.</p>",
                'author' => $request['created_by'],
                'group_associated' => $request['group_associated'],
            ]);

            // Log storage. 
            $log = array(
                'author_id' => Auth::user()->id,
                'action' => 'creado el hilo <span style="color:#6013bb;">\'' . $request['title'] . '\'</span>',
                'tab' => 'foro',
                'entity_implied' => $request['group_associated'],
                'isGroup' => true,
            );
            saveActivityLog($log);
            // End log storage

            //Update notifications_json to prevent system to show this new thread as 'not visited'.
            $json_decode = json_decode(Auth::user()->notifications_json, true);
            $json_decode['groupForum'][$thread->id]['lastVisit'] = date("Y-m-d H:i:s", time());
            Auth::user()->notifications_json = json_encode($json_decode);
            Auth::user()->save();
            //End update to notifications_json

            $group = Group::find($request['group_associated']);
            return redirect()->route('group.show', ['group' => $group, 'tab' => 'foro']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function show($threadId)
    {
        return view("common_sections.thread", ["thread" => ForumThread::findOrFail($threadId)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function edit(ForumThread $forumThread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $thread = ForumThread::find($request['id_thread']);
        $thread->description = $request['description'] != null ? $request['description'] : 'Contenido no disponible';
        $thread->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $thread = ForumThread::find($request['thread_id']);

        // Log storage. 
        $log = array();
        if ($thread->user_associated != null) {
            $log = array(
                'author_id' => Auth::user()->id,
                'action' => 'eliminado el hilo <span style="color:#6013bb;">\'' . $thread->title . '\'</span>',
                'tab' => 'foro',
                'entity_implied' => $thread->user_associated
            );
        } else {
            $log = array(
                'author_id' => Auth::user()->id,
                'action' => 'eliminado el hilo <span style="color:#6013bb;">\'' . $thread->title . '\'</span>',
                'tab' => 'foro',
                'entity_implied' => $thread->group_associated,
                'isGroup' => true
            );
        }
        saveActivityLog($log);
        // End log storage

        $thread->delete();


        if ($request['return_to_forum'] == 1) {
            $user = $thread->model;
            return redirect()->route('profile.show', ["user" => $user, 'tab' => 'foro']);
        }
    }


    public function pinThread(Request $request)
    {
        $thread = ForumThread::find($request['thread_id']);
        $thread->pinned = $thread->pinned == 0 ? 1 : 0;

        //We can only pin 1 thread -> setting as not pinned the previous pinned threads
        DB::table('forum_threads')
            ->where('pinned', '1')
            ->where('id', '!=', $thread->id)
            ->update(['pinned' => 0]);

        $thread->save();
    }
}
