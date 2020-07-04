<?php

namespace App\Http\Controllers;

use App\ForumReply;
use Illuminate\Http\Request;

class ForumReplyController extends Controller
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
        if ($request != null) {
            $reply = ForumReply::create([
                'thread_id' => $request['thread_id'],
                'description' => $request['description'],
                'author' => $request['author'],
            ]);
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
