<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\UserFile;
use Carbon\Carbon;
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
        $notifications = $this->getThingsUserHasntSeenYet($threads);
        return view('home', [
            'user' => Auth::user(),
            'trainingPlans' => $trainingPlans,
            'invoices' => $invoices,
            'tab' => $tab != null ? $tab : 'general',
            'threads' => $threads,
            'userFiles' => $files,
            'notifications' => $notifications,
        ]);
    }


    public function getThingsUserHasntSeenYet($threads)
    {
        $thingsUserHasntSeenYet = array();

        $json = json_decode(Auth::user()->notifications_json, true);

        $threadsChanges = 0;

        //Threads 
        foreach ($threads as $thread) {

            $userLogTimestamp = isset($json['forum'][$thread->id]['lastVisit']) ? Carbon::parse($json['forum'][$thread->id]['lastVisit'])->timestamp : 0;
            $threadLastUpdateTimestamp = $thread->updated_at->timestamp;

            if ($threadLastUpdateTimestamp > $userLogTimestamp) {
                //There're changes user hasn't seen inside the thread. 

                //Let's count how many replies the user hasn't seen. 
                $changesCount = 0;
                $replies = $thread->replies;

                foreach ($replies as $reply) {
                    //We're only counting new replies, not modifications in existing replies. 
                    $replyCreatedTimestamp = $reply->created_at->timestamp;

                    if ($replyCreatedTimestamp > $userLogTimestamp && $userLogTimestamp > 0) {
                        //The user hasn't seen that reply. Increasing the counter by 1
                        $changesCount++;
                    }
                }

                //If 'changesCount' == 0, thread has just been created or has been updated
                // If the user has previously seen the thread but it has been updated, then the system won't notify it
                if ($changesCount == 0) {
                    if ($thread->created_at == $thread->updated_at) {
                        //Thread has been created. 
                        $changesCount++;
                        $thingsUserHasntSeenYet['forum'][$thread->id] = 'new';
                    } else {
                        if ($thread->created_at->timestamp > $userLogTimestamp) {
                            //Even though the thread has been updated, the user has never seen the thread. 
                            $changesCount++;
                            $thingsUserHasntSeenYet['forum'][$thread->id] = 'new';
                        }
                    }
                } else {
                    $threadsChanges += $changesCount;
                    $thingsUserHasntSeenYet['forum'][$thread->id] = $changesCount;
                }
            }
        }
        return  $thingsUserHasntSeenYet;
    }
}
