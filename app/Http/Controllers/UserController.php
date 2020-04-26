<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //Shows user's profile
    public function showProfile($id)
    {
        $user = User::find($id);
        return view('show-profile', [
            'user' => $user,
        ]);
    }

    public function updateAvatar(Request $request)
    {
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
        return redirect()->route('profile.show', Auth::user()->id);
    }
}
