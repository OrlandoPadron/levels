<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\UserFile;
use Carbon\Carbon;
use App\ForumThread;
use App\Group;
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
        if (!Auth::user()->isTrainer) {
            $trainingPlans = Auth::user()->athlete->trainingPlans;
            $invoices = Invoice::where('athlete_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
            $threads = ForumThread::where('user_associated', Auth::user()->id)->get();
            $files = UserFile::where('owned_by', Auth::user()->id)->get();
            $groups = Group::where('athletes', 'like', "%" . Auth::user()->athlete->id . "%")->get();
            $notifications = array(
                "threads" => $this->getForumElementsUserHasntSeenYet($threads),
                "gthreads" => $this->getGroupForumElementsUserHasntSeenYet($groups),

            );
            return view('home', [
                'user' => Auth::user(),
                'trainingPlans' => $trainingPlans,
                'invoices' => $invoices,
                'tab' => $tab != null ? $tab : 'general',
                'threads' => $threads,
                'userFiles' => $files,
                'notifications' => $notifications,
            ]);
        } else {
            return redirect()->route('home');
        }
    }


    public function getForumElementsUserHasntSeenYet($threads)
    {
        $threadsUserHasntSeenYet = array();

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
                        $threadsChanges += $changesCount;
                        $threadsUserHasntSeenYet[$thread->id]['isNew'] = true;
                        $threadsUserHasntSeenYet[$thread->id]['numOfChanges'] = $changesCount;
                    } else {
                        if ($thread->created_at->timestamp > $userLogTimestamp) {
                            //Even though the thread has been updated, the user has never seen the thread. 
                            $changesCount++;
                            $threadsChanges += $changesCount;

                            $threadsUserHasntSeenYet[$thread->id]['isNew'] = true;
                            $threadsUserHasntSeenYet[$thread->id]['numOfChanges'] = $changesCount;
                        }
                    }
                } else {
                    $threadsChanges += $changesCount;
                    $threadsUserHasntSeenYet[$thread->id]['numOfChanges'] = $changesCount;
                }
            }
        }
        $threadsUserHasntSeenYet['totalNumOfNewChanges'] = $threadsChanges;
        return  $threadsUserHasntSeenYet;
    }



    public function getGroupForumElementsUserHasntSeenYet($groups)
    {
        $groupThreadsUserHasntSeenYet = array();
        $json = json_decode(Auth::user()->notifications_json, true);

        $threadsChanges = 0;

        //Lets get all the threads associated with each group. 
        foreach ($groups as $group) {

            $threads = ForumThread::where('group_associated', $group->id)->get();

            //Threads 
            foreach ($threads as $thread) {

                $userLogTimestamp = isset($json['groupForum'][$thread->id]['lastVisit']) ? Carbon::parse($json['groupForum'][$thread->id]['lastVisit'])->timestamp : 0;
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
                            $threadsChanges += $changesCount;

                            $groupThreadsUserHasntSeenYet[$group->id][$thread->id]['isNew'] = true;
                            $groupThreadsUserHasntSeenYet[$group->id][$thread->id]['numOfChanges'] = $changesCount;
                        } else {
                            if ($thread->created_at->timestamp > $userLogTimestamp) {
                                //Even though the thread has been updated, the user has never seen the thread. 
                                $changesCount++;
                                $threadsChanges += $changesCount;
                                $groupThreadsUserHasntSeenYet[$group->id][$thread->id]['isNew'] = true;
                                $groupThreadsUserHasntSeenYet[$group->id][$thread->id]['numOfChanges'] = $changesCount;
                            }
                        }
                    } else {
                        $threadsChanges += $changesCount;
                        $groupThreadsUserHasntSeenYet[$group->id][$thread->id]['numOfChanges'] = $changesCount;
                    }
                }
            }
        }
        $groupThreadsUserHasntSeenYet['totalNumOfNewChanges'] = $threadsChanges;
        return $groupThreadsUserHasntSeenYet;
    }
}
