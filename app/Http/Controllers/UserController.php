<?php

namespace App\Http\Controllers;

use App\User;
use App\Athlete;
use App\ForumThread;
use App\Invoice;
use App\UserFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

use function GuzzleHttp\json_encode;

class UserController extends Controller
{
    //Shows user's profile
    public function showProfile($id, $tab)
    {
        $user = User::find($id);
        if ($user->isTrainer == 1) {
            return view('show-profile', [
                'user' => $user
            ]);
        } else {
            $trainingPlans = $user->athlete->trainingPlans;
            $invoices = Invoice::where('athlete_id', $user->athlete->id)->orderBy('id', 'DESC')->get();
            $threads = ForumThread::where('user_associated', $user->id)->get();
            $files = UserFile::where('owned_by', $user->id)->get();
            return view('show-profile', [
                'user' => $user,
                'trainingPlans' => $trainingPlans,
                'invoices' => $invoices,
                'tab' => $tab != null ? $tab : 'general',
                'threads' => $threads,
                'userFiles' => $files,
            ]);
        }
    }

    public function showEditProfile()
    {
        return view('edit-profile');
    }


    public function updateAvatar(Request $request)
    {
        if ($request->get('delete-avatar') == true) {
            $this->deleteAvatarAndSetDefaultAvatar($request);
        }

        //Handle user uploaded avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->fit(500, 500)->save(public_path('uploads/avatars/' . $filename));

            $logged_user = Auth::user();

            // Delete previous avatar
            $previous_file = $logged_user->user_image;
            if ($previous_file != 'default_avatar.jpg') {
                if (file_exists('uploads/avatars/' . $previous_file)) {
                    unlink('uploads/avatars/' . $previous_file);
                }
            }

            //Update avatar
            $logged_user->user_image = $filename;
            $logged_user->save();
        }
        return redirect()->route('profileEdit.show');
    }

    private function deleteAvatarAndSetDefaultAvatar(Request $request)
    {

        $logged_user = Auth::user();
        // Delete previous avatar
        $previous_file = $logged_user->user_image;
        if ($previous_file != 'default_avatar.jpg') {
            if (file_exists('uploads/avatars/' . $previous_file)) {
                unlink('uploads/avatars/' . $previous_file);
            }
        }
        //Updates avatar
        $logged_user->user_image = 'default_avatar.jpg';
        $logged_user->save();
    }

    public function trainThisAthlete(Request $request)
    {
        // Find athlete and change 'trainer_id' 
        $user = User::find($request['user_id']);

        $athlete = $user->athlete;
        $athlete->trainer_id = Auth::user()->trainer->id;

        $athlete->save();

        //Add athlete id to trainers' 'trained_by_me' field
        $trainer = Auth::user()->trainer;
        $array = (array) $trainer->trained_by_me;
        array_push($array, $athlete->id);
        $trainer->trained_by_me = $array;
        $trainer->save();

        return redirect()->route('profile.show', ["user" => $user, 'tab' => 'general']);
    }


    public function stopTrainingThisAthlete(Request $request)
    {
        // Find athlete and delete 'trainer_id' 
        $athlete = User::find($request['user_id'])->athlete;
        $athlete->trainer_id = null;
        $athlete->save();

        //Remove athlete's id from trainers' 'trained_by_me' field
        $trainer = Auth::user()->trainer;
        $array = (array) $trainer->trained_by_me;
        $delete = array($athlete->id);
        $trainer->trained_by_me = array_diff($array, $delete);
        $trainer->save();

        $user = User::find($request['user_id']);
        return redirect()->route('profile.show', ["user" => $user, 'tab' => 'general']);
    }



    public function uploadFile(Request $request)
    {
        //Handle user uploaded avatar
        if ($request->hasFile('fileuploaded')) {
            $files = $request->file('fileuploaded');

            // Get user's uploads folder
            $path = 'uploads/files/' . $request['user_id'];

            // !TODO check if a file with same name exists. 

            foreach ($files as $file) {
                $file->move($path, $file->getClientOriginalName());
            }

            $allFiles = File::allfiles(public_path($path));
            return view('home', ['allFiles' => $allFiles]);
        }
    }


    /**
     * Activate accounts. Activates a deactivated account. 
     */

    public function activateAccount(Request $request)
    {
        if ($request['user_id'] != null) {
            $user = User::find($request['user_id']);
            $user->account_activated = 1;
            $user->save();
            return redirect()->route('profile.show', ["user" => $user, "tab" => 'general']);
        }
    }


    /**
     * Deactivates accounts. Prevents the page from generating 
     * monthly invoices for a given account. 
     * 
     */
    public function deactivateAccount(Request $request)
    {
        if ($request['user_id'] != null) {
            $user = User::find($request['user_id']);
            $user->account_activated = 0;
            $user->save();
            return redirect()->route('profile.show', ["user" => $user, "tab" => 'general']);
        }
    }



    /**
     * Updates notifications json file in users database.
     */

    public function updateServiceAccessesDates(Request $request)
    {

        if (isset($request['method'])) {
            $json_decode = json_decode(Auth::user()->notifications_json, true);

            switch ($request['method']) {
                case 'forum':
                    $json_decode['forum'][$request['id']]['lastVisit'] = date("Y-m-d H:i:s", time());
                    Auth::user()->notifications_json = json_encode($json_decode);
                    Auth::user()->save();
                    break;
                case 'groupForum':
                    break;
                case 'trainingPlans':
                    break;
            }
        }
    }


    /**
     * Method relate to My Wall section. 
     */

    public function myWall(Request $request)
    {

        if (isset($request['method'])) {
            $json_decode = json_decode(Auth::user()->my_wall, true);
            switch ($request['method']) {
                case 'newSection':
                    $id = time();
                    $position = count($json_decode) + 1;
                    $json_decode[$id] = array(
                        'title' => $request['title'],
                        'content' => $request['content'],
                        'position' => $position
                    );
                    Auth::user()->my_wall = json_encode($json_decode);
                    Auth::user()->save();
                    break;
            }
            return redirect()->route('athlete.home', 'muro');
        }
    }
}
