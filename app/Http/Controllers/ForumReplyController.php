<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumReplyController extends Controller
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
        if ($request != null) {
            $reply = ForumReply::create([
                'thread_id' => $request['thread_id'],
                'description' => $request['description'],
                'author' => Auth::user()->id,
            ]);

            // Log storage. 
            $log = array();
            if ($reply->thread->user_associated != null) {
                $log = array(
                    'author_id' => Auth::user()->id,
                    'action' => 'respondido al hilo <span style="color:#6013bb;">\'' . $reply->thread->title . '\'</span>',
                    'tab' => 'foro',
                    'entity_implied' => $reply->thread->user_associated
                );
            } else {
                $log = array(
                    'author_id' => Auth::user()->id,
                    'action' => 'respondido al hilo <span style="color:#6013bb;">\'' . $reply->thread->title . '\'</span>',
                    'tab' => 'foro',
                    'entity_implied' => $reply->thread->group_associated,
                    'isGroup' => true
                );
            }
            saveActivityLog($log);
            // End log storage

            //Updates thread 'updated_at' field
            $reply->thread->updated_at = Carbon::now();
            $reply->thread->save();


            return $reply->id;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function show($forumReplyId)
    {
        return view("common_sections.components.replyComponent", ["reply" => ForumReply::findOrFail($forumReplyId)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function edit(ForumReply $forumReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $reply = ForumReply::find($request['id_reply']);
        $reply->description = $request['description'] != null ? $request['description'] : 'Contenido no disponible';
        $reply->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ForumReply  $forumReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $reply = ForumReply::find($request['reply_id']);
        $thread_id = $reply->thread_id;
        $reply->delete();
        return ForumReply::where('thread_id', $thread_id)->count();
    }
}
