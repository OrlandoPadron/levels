<?php

namespace App\Http\Controllers;

use App\User;
use App\Group;
use App\Athlete;
use App\Invoice;
use App\Trainer;
use App\UserFile;
use Carbon\Carbon;
use App\ForumThread;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.exists');
    }

    //Shows user's profile
    public function showProfile($id, $tab)
    {
        $user = User::find($id);
        if (!Auth::user()->isTrainer && !$user->isTrainer) return redirect()->route('athlete.home', 'general');


        $threads = ForumThread::where('user_associated', $user->id)->get();
        $files = UserFile::where('owned_by', $user->id)->get();
        if ($user->isTrainer == 1) {
            return view('show-profile', [
                'user' => $user,
                'tab' => $tab != null ? $tab : 'general',
                'threads' => $threads,
                'userFiles' => $files,
            ]);
        } else {
            $homeController = new HomeController;
            $trainingPlans = $user->athlete->trainingPlans;
            $invoices = Invoice::where('athlete_id', $user->athlete->id)->orderBy('id', 'DESC')->get();
            $notifications = array(
                "trainingPlansUpdates" => $homeController->getArrayOfTrainingPlansUpdates(),
                "threads" => $homeController->getForumElementsUserHasntSeenYet($threads),
            );
            return view('show-profile', [
                'user' => $user,
                'trainingPlans' => $trainingPlans,
                'invoices' => $invoices,
                'tab' => $tab != null ? $tab : 'general',
                'threads' => $threads,
                'userFiles' => $files,
                'notifications' => $notifications,
            ]);
        }
    }

    public function showEditProfile()
    {
        return view('edit-profile');
    }

    /**
     * Shows administration dashboard. 
     * Only accessible by admins. 
     */
    public function showAdminDashboard()
    {
        if (Auth::user()->admin) {

            $users = User::all();
            $files = UserFile::all();
            return view('admin-dashboard', [
                "users" => $users,
                "files" => $files,
            ]);
        } else {
            return redirect()->route('home');
        }
    }


    /**
     * Admin management's methods
     */
    public function adminManagement(Request $request)
    {

        if ((Auth::user()->admin) && (isset($request['method']))) {
            switch ($request['method']) {
                case 'editUserProfile':
                    //Updating user's name and surname
                    if (isset($request['name']) && isset($request['surname'])) {
                        $this->updateNames($request['name'], $request['surname'], $request['userId']);
                    }

                    return Redirect::back();

                case 'toggleAdminStatus':
                    $user = User::find($request['userId']);
                    if ($user->isTrainer) {
                        $user->admin = $user->admin == 1 ? 0 : 1;
                        $user->save();
                    } else {
                        return response()->json([
                            'message' => 'User input not valid. Trainer not found.',
                        ], 409);
                    }
                    break;

                    // Activates/Deactivates an account. 
                case 'toggleAccountStatus':
                    $user = User::find($request['userId']);
                    $user->account_activated = $user->account_activated == 1 ? 0 : 1;
                    $user->save();
                    break;
            }
        } else {
            return redirect()->route('home');
        }
    }

    /**
     * Updates user's personal informations. Some of this 
     */
    public function updateProfileInfo(Request $request)
    {
        //Updating user's name and surname
        if (isset($request['name']) && isset($request['surname'])) {
            $this->updateNames($request['name'], $request['surname'], Auth::user()->id);
        }

        //Getting user object.  
        $user = User::findOrFail(Auth::user()->id);

        //Gender
        if (isset($request['gender'])) {
            $option = $request['gender'];
            switch ($option) {
                case 'man':
                    $user->gender = "male";
                    break;
                case 'woman':
                    $user->gender = "female";
                    break;
                default:
                    $user->gender = null;
                    break;
            }
        }

        //Trainers have no additional information left. 
        if (Auth::user()->isTrainer) {
            $user->save();
            return Redirect::back();
        }

        //Athlete's additional information
        $additionalInfo_array = array();

        //Birthday
        if (isset($request['birthday'])) {
            $additionalInfo_array['additionalInfo']['birthday'] = $request['birthday'];
        }
        //DNI
        if (isset($request['dni'])) {
            $additionalInfo_array['additionalInfo']['dni'] = $request['dni'];
        }
        //Address
        if (isset($request['address'])) {
            $additionalInfo_array['additionalInfo']['address'] = $request['address'];
        }
        //Phone Number
        if (isset($request['phone_number'])) {
            $additionalInfo_array['additionalInfo']['phone'] = $request['phone_number'];
        }
        //Occupation 
        if (isset($request['occupation'])) {
            $additionalInfo_array['additionalInfo']['occupation'] = $request['occupation'];
        }

        $user->additional_info = Crypt::encryptString(json_encode($additionalInfo_array));


        $user->save();

        return Redirect::back();
    }

    /**
     * Updates user's name depending if numerous values were issued. 
     */
    private function updateNames($nameUnsplit, $surnameUnsplit, $userId)
    {

        $names = explode(",", trim($nameUnsplit));
        $surnames = explode(",", trim($surnameUnsplit));

        $user = User::find($userId);

        //Name case 
        if (count($names) >= 2) {
            $user->name = trim($names[0]);
            $name2 = null;
            for ($i = 1; $i < count($names); $i++) {
                $name2 .= trim($names[$i]) . ' ';
            }
            $user->name2 = trim($name2);
        } else {
            $user->name = trim($names[0]);
            $user->name2 = null;
        }

        //Surname case 
        if (count($surnames) >= 2) {
            $user->surname = trim($surnames[0]);
            $surname2 = null;
            for ($i = 1; $i < count($surnames); $i++) {
                $surname2 .= trim($surnames[$i]) . ' ';
            }
            $user->surname2 = trim($surname2);
        } else {
            $user->surname = trim($surnames[0]);
            $user->surname2 = null;
        }
        $user->save();
    }


    /**
     * Updates user's third parties account information. 
     */
    public function updateThirdPartiesInfo(Request $request)
    {
        //Getting user object.  
        $user = Auth::user();

        //Users's additional information
        $additionalInfo = null;
        if ($user->additional_info != '{}') {
            $decrypt = Crypt::decryptString($user->additional_info);
            $additionalInfo = json_decode($decrypt, true);
        } else {
            $additionalInfo = json_decode($user->additional_info, true);
        }

        foreach ($request->request as $key => $value) {
            if ($key != '_token') {
                $additionalInfo['thirdParties'][$key] = $value;
            }
        }
        $user->additional_info = Crypt::encryptString(json_encode($additionalInfo));
        $user->save();
        return Redirect::back();
    }

    /**
     * Updates user's email.
     */
    public function updateEmail(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'string', 'email', 'max:255']
            ]
        );

        if (isset($request['email'])) {
            $oldEmail = Auth::user()->email;
            $newEmail = $request['email'];
            if ($oldEmail != $newEmail) {
                try {
                    Auth::user()->email = $newEmail;
                    Auth::user()->save();
                } catch (QueryException $ex) {
                    return response()->json([
                        'message' => 'QueryException',
                        'code' => 2300,
                    ], 409);
                }
            }
        }
    }

    /**
     * Changes user's passwords. 
     */
    public function updatePassword(Request $request)
    {
        if (isset($request['oldPassword']) && (isset($request['newPassword']))) {
            $oldPassword = $request['oldPassword'];

            if (password_verify($oldPassword, Auth::user()->password)) {
                $request->validate(
                    [
                        'newPassword' => ['required', 'string', 'min:8', 'confirmed']
                    ]
                );

                Auth::user()->password = Hash::make($request['newPassword']);
                Auth::user()->save();
            } else {
                return response()->json([
                    'message' => 'Not valid input. Old password doesn\'t match.'
                ], 401);
            }
        }
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
                    $json_decode['groupForum'][$request['id']]['lastVisit'] = date("Y-m-d H:i:s", time());
                    Auth::user()->notifications_json = json_encode($json_decode);
                    Auth::user()->save();
                    break;
                case 'trainingPlans':
                    $json_decode['trainingPlans'][$request['id']]['lastVisit'] = date("Y-m-d H:i:s", time());
                    Auth::user()->notifications_json = json_encode($json_decode);
                    Auth::user()->save();
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
            switch ($request['method']) {
                case 'newSection':
                    $json_decode = json_decode(Auth::user()->my_wall, true);
                    $id = time();
                    $position = count($json_decode) + 1;
                    $json_decode[$id] = array(
                        'title' => 'Sin título',
                        'content' => 'Sin contenido',
                        'position' => strval($position),
                    );
                    Auth::user()->my_wall = json_encode($json_decode);
                    Auth::user()->save();
                    break;

                case 'updateSection':
                    $json_decode = json_decode(Auth::user()->my_wall, true);
                    $id = $request['id'];
                    $json_decode[$id]['title'] = $request['title'];
                    $json_decode[$id]['content'] = $request['content'];

                    //Change orders in case we should do it. 
                    if ($request['newPosition'] !== "-1") {
                        $oldPosition = $json_decode[$id]['position'];
                        $json_decode[$id]['position'] = $request['newPosition'];
                        $id_target = $this->getIdOfSectionWithDuplicatedNewPosition($request['newPosition']);
                        $json_decode[$id_target]['position'] = $oldPosition;
                    }
                    Auth::user()->my_wall = json_encode($json_decode);
                    Auth::user()->save();
                    break;

                case 'deleteSection':
                    $user = User::findOrFail($request['userId']);
                    $json_decode = json_decode($user->my_wall, true);

                    unset($json_decode[$request['id']]);

                    $user->my_wall = json_encode($json_decode);
                    $user->save();
                    break;
            }
            if (Auth::user()->isTrainer) {
                return redirect()->route('profile.show', [Auth::user()->id, "general"]);
            } else {
                return redirect()->route('athlete.home', 'muro');
            }
        }
    }

    public function getIdOfSectionWithDuplicatedNewPosition($newPosition)
    {
        $json_decode = json_decode(Auth::user()->my_wall, true);
        foreach ($json_decode as $id => $section) {
            if (strval($section['position']) == strval($newPosition)) {
                return $id;
            }
        }
    }

    /**
     * Destroys user's account and files associated. 
     */
    public function destroyUser(Request $request)
    {
        //Only admin users can delete users. 
        if (Auth::user()->admin && isset($request['userId'])) {

            $user = User::find($request['userId']);
            dump('Usuario encontrado');


            /**
             * If user is Trainer, remove it from athlete's trainer id,
             * If user is Athlete, remove it from trainer's athletes list
             */

            if ($user->isTrainer) {
                $athletes = getArrayOfAthletesTrainedByTrainerId($user->trainer->id);
                foreach ($athletes as $athlete) {
                    $athlete->trainer_id = null;
                    dump('Se ha eliminado el id del entrenador del atleta');
                    $athlete->save();
                }
            } else {
                $trainer = Trainer::find($user->athlete->trainer_id);
                dump('Se ha encontrado el trainer');
                $trainer->trained_by_me = array_values(array_diff((array)$trainer->trained_by_me, (array) $user->athlete->id));
                $trainer->save();
                dump('Trainer guardado');
            }

            //Remove user's id from files shared with user 
            $files = UserFile::where('shared_with', 'like', "%\"$user->id\"%")->get();
            foreach ($files as $file) {
                $file->shared_with   = array_values(array_diff((array)$file->shared_with, (array) $user->id));
                $file->save();
                dump('File shared updated');
            }

            //Removing user's files from group shared files. 
            foreach ($user->files() as $file) {
                $groupsWithFileShared = Group::where('files', 'like', "%\"$file->id\"%")->get();
                foreach ($groupsWithFileShared as $group) {
                    $group->files = array_values(array_diff($group->files, (array) $file->id));
                    $group->save();
                }
            }


            //Groups where user is member. 
            $groups = getUserGroupsByUserId($user->id);

            //In case user is owner, the group is destroyed. 
            foreach ($groups as $group) {
                dump($group->id);

                if ($group->creator->id == $user->id) {
                    dump('Es creador del grupo');

                    //Unlink group image from app. 
                    if ($group->group_image != 'default_group_avatar.jpg') {
                        if (file_exists('uploads/group_avatars/' . $group->group_image)) {
                            unlink('uploads/group_avatars/' . $group->group_image);
                        }
                    }

                    $group->delete();
                    dump('Grupo eliminado');
                } else {
                    dump('No es creador del grupo');
                    //Removing user from group
                    $userDeletedRole = getUserRole($group->id, $user->id);
                    $groupMembers = (array) $group->users;
                    $group->users = array_values(array_diff($groupMembers, (array) $user->id));

                    if ($userDeletedRole == 'Administrador') {
                        $group->admins = array_values(array_diff((array)$group->admins, (array) $user->id));
                    }
                    $group->save();
                    dump('Grupo actualizado');
                }
            }

            //User delete 

            //Deleting user image from application
            if ($user->user_image != 'default_avatar.jpg') {
                if (file_exists('uploads/avatars/' . $user->user_image)) {
                    dump('Imagen eliminada');

                    unlink('uploads/avatars/' . $user->user_image);
                }
            }
            dump('Hemos llegado al final');
            $user->delete();

            return Redirect::back();
        }
    }
}
