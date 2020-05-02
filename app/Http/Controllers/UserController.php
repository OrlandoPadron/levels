<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    //Shows user's profile
    public function showProfile($id)
    {
        $user = User::find($id);
        if ($user->isTrainer == 1) {
            return view('show-profile', [
                'user' => $user
            ]);
        } else {
            $trainingPlans = $user->athlete->trainingPlans;
            return view('show-profile', [
                'user' => $user,
                'trainingPlans' => $trainingPlans
            ]);
        }
    }

    public function showEditProfile()
    {
        $user = Auth::user();
        return view('edit-profile');
    }


    public function updateAvatar(Request $request)
    {
        $this->deleteAvatarAndSetDefaultAvatar($request);

        //Handle user upload of avatar
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            Image::make($avatar)->fit(500, 500)->save(public_path('uploads/avatars/' . $filename));

            $logged_user = Auth::user();

            // Delete previous avatar
            $previous_file = $logged_user->user_image;
            if ($previous_file != 'default_avatar.jpg') {
                unlink('uploads/avatars/' . $previous_file);
            }

            //Updates avatar
            $logged_user->user_image = $filename;
            $logged_user->save();
        }
        return redirect()->route('profileEdit.show');
    }

    private function deleteAvatarAndSetDefaultAvatar(Request $request)
    {
        if ($request->get('delete-avatar') == true) {
            $logged_user = Auth::user();
            // Delete previous avatar
            $previous_file = $logged_user->user_image;
            if ($previous_file != 'default_avatar.jpg') {
                unlink('uploads/avatars/' . $previous_file);
            }
            //Updates avatar
            $logged_user->user_image = 'default_avatar.jpg';
            $logged_user->save();
        }
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

        return redirect()->route('profile.show', ["user" => $user]);
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
        return redirect()->route('profile.show', ["user" => $user]);
    }
}
