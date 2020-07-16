<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\UserFile;
use App\ForumThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->isTrainer) {
            return view('home');
        } else {
            return redirect()->route('athlete.home', 'general');
        }
    }

    public function athleteHome($tab)
    {
        $trainingPlans = Auth::user()->athlete->trainingPlans;
        $invoices = Invoice::where('athlete_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        $threads = ForumThread::where('user_associated', Auth::user()->id)->get();
        $files = UserFile::where('owned_by', Auth::user()->id)->get();
        return view('home', [
            'user' => Auth::user(),
            'trainingPlans' => $trainingPlans,
            'invoices' => $invoices,
            'tab' => $tab != null ? $tab : 'general',
            'threads' => $threads,
            'userFiles' => $files,
        ]);
    }
}
