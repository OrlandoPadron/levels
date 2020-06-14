<?php

namespace App\Http\Controllers;

use App\User;
use App\Athlete;
use App\Invoice;
use App\Tutorship;
use Illuminate\Http\Request;

class TutorshipController extends Controller
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
        // tutorshipNumber represents its index inside athlete's tutorships. 
        $tutorshipNumber = Athlete::find($request['athlete_associated'])->tutorships()->count() + 1;
        Tutorship::create([
            'title' => $request['title'] != null ? $request['title'] : 'Tutoría #' . $tutorshipNumber,
            'date' => $request['date'] != null ? $request['date'] : date('d/m/Y'),
            'goal' => $request['goal'] != null ? $request['goal'] : "Objetivo no especificado.",
            'description' => $request['description'] != null ? $request['description'] : "<p>Esta tutoría no tiene contenido.</p>",
            'athlete_associated' => $request['athlete_associated'],
            'bookmarked' => ($request['bookmark'] == 'bookmark_set') ? 1 : 0,
            'tutorship_number' => $tutorshipNumber,
        ]);

        $user = User::find($request['user_id']);
        return redirect()->route('profile.show', ['user' => $user, 'tab' => 'tutorias']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tutorship  $tutorship
     * @return \Illuminate\Http\Response
     */
    public function show(Tutorship $tutorship)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tutorship  $tutorship
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutorship $tutorship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tutorship  $tutorship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $tutorship = Tutorship::find($request['id_tutorship']);
        $tutorship->title = $request['title'];
        $tutorship->goal = $request['goal'];
        $tutorship->date = $request['date'];
        $tutorship->description = $request['description'];
        $tutorship->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tutorship  $tutorship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tutorship = Tutorship::find($request['id_tutorship']);
        $tutorship->delete();
    }


    public function toggleBookmark(Request $request)
    {
        $tutorship = Tutorship::find($request['id_tutorship']);
        if ($tutorship->bookmarked == 1) {
            $tutorship->bookmarked = 0;
        } else {
            $tutorship->bookmarked = 1;
        }
        $tutorship->save();
    }
}
