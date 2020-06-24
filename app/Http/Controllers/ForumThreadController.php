<?php

namespace App\Http\Controllers;

use App\User;
use App\ForumThread;
use Illuminate\Http\Request;

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

        ForumThread::create([
            'title' => $request['title'] != null ? $request['title'] : 'Hilo sin título',
            'description' => $request['description'] != null ? $request['description'] : "<p>Este hilo no tiene contenido.</p>",
            'author' => $request['created_by'],
            'user_associated' => $request['user_associated'],
        ]);

        $user = User::find($request['user_associated']);
        return redirect()->route('profile.show', ['user' => $user, 'tab' => 'foro']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ForumThread  $forumThread
     * @return \Illuminate\Http\Response
     */
    public function show($threadId)
    {
        return view("sections_dashboard.thread", ["thread" => ForumThread::findOrFail($threadId)]);
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
        $thread->delete();

        if ($request['return_to_forum'] == 1) {
            $user = $thread->model;
            return redirect()->route('profile.show', ["user" => $user, 'tab' => 'foro']);
        }
    }
}
