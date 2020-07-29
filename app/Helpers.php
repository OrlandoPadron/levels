<?php

use App\User;
use App\Group;
use App\Athlete;
use App\Trainer;
use App\UserFile;
use App\ActivityLog;
use App\TrainingPlan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Mockery\Undefined;

use function GuzzleHttp\json_decode;

function setActive($tab)
{
    if ($tab == "general") {
        return request()->routeIs('profile.show') ? 'active-dashboard' : '';
    }
    return Request::get('tab') == $tab ? 'active-dashboard' : '';
}


/**
 * Function used to determine if a given trainer is currently training a 
 * specific athlete. 
 */
function iAmcurrentlyTrainingThisAthlete($athlete_id)
{
    if (!Auth::user()->isTrainer) return false;
    $athletes_trained = (array) Auth::user()->trainer->trained_by_me;
    if (in_array($athlete_id, $athletes_trained)) {
        return true;
    } else {
        return false;
    }
}


/**
 * Returns trainers name given an user id. 
 */

function getTrainersName($user_id)
{
    $trainers_id = User::find($user_id)->athlete->trainer_id;
    $trainer = Trainer::find($trainers_id)->user;
    return $trainer->name . ' ' . $trainer->surname;
}

function getUserIdByTrainerId($trainerId)
{
    return Trainer::findOrFail($trainerId)->user->id;
}

/**
 * Returns trainers name given a trainer_id. 
 */
function getTrainersNameByTrainerId($trainer_id)
{
    $trainer = Trainer::find($trainer_id)->user;
    return $trainer->name . ' ' . $trainer->surname;
}

function getTrainerByTrainerId($trainerId)
{
    return Trainer::findOrFail($trainerId);
}


/**
 * Given an user id, returns his name. 
 */

function getName($user_id)
{
    $user = User::find($user_id);
    return $user->name . ' ' . $user->surname;
}

/**
 * Given an user id, return its user model. 
 */

function getUser($user_id)
{
    return User::findOrFail($user_id);
}

function getUserUsingAthleteId($id)
{
    $user = Athlete::find($id)->user;
    return $user;
}

/**
 * Given a trainer_id, returns an array with all
 * the users trained by that trainer
 */
function getArrayOfUsersTrainedByMe($trainer_id)
{
    $users = array();
    $trainer = Trainer::findOrFail($trainer_id);
    foreach ($trainer->trained_by_me as $user_id) {
        array_push($users, getUserUsingAthleteId($user_id));
    }
    return $users;
}

function getArrayOfAthletesTrainedByTrainerId($trainerId)
{
    $athletes = array();
    $trainer = Trainer::findOrFail($trainerId);
    foreach ($trainer->trained_by_me as $user_id) {
        array_push($athletes, getUserUsingAthleteId($user_id)->athlete);
    }
    return $athletes;
}

function getArrayOfAthletesWhoHaventPayMonthYet($trainerId)
{
    $athletes = getArrayOfAthletesTrainedByTrainerId($trainerId);
    $haventPay = array();
    foreach ($athletes as $athlete) {
        if (!$athlete->monthPaid) {
            array_push($haventPay, $athlete);
        }
    }
    return $haventPay;
}


/**
 * Given a group, function returns all group members as User Model array. 
 */
function getGroupUsers($groupId)
{
    $athletesIds = Group::find($groupId)->athletes;
    if (empty($athletesIds)) return collect();
    $usersArray = collect();

    foreach ($athletesIds as $athleteId) {
        $user = Athlete::find($athleteId)->user;
        $usersArray->add($user);
    }
    return $usersArray;
}


function athleteIsNotMemberOfThisGroup($groupId, $athlete_id)
{
    $groupMembers = (array) Group::find($groupId)->athletes;
    if (in_array($athlete_id, $groupMembers)) {
        return false;
    } else {
        return true;
    }
}


function getNumberOfTutorshipsWithBookmark()
{
    return DB::table('tutorships')
        ->where('bookmarked', 1)
        ->count();
}

function getUserFilesNotSharedWithCurrentUser($userLoggedInId, $userId)
{
    $files = UserFile::where('owned_by', $userLoggedInId)
        ->where('shared_with', 'not like', "%\"$userId\"%")
        ->get();
    return $files;
}

function getUsersFiles($userId)
{
    return UserFile::where('owned_by', $userId)->get();
}

function getFilesSharedWithUser($userId)
{
    $sharedFiles = array();
    $files = UserFile::where('shared_with', 'like', "%\"$userId\"%")->get();
    foreach ($files as $file) {
        if (in_array($userId, (array) $file->shared_with)) {
            array_push($sharedFiles, $file);
        }
    }
    return $sharedFiles;
}

function getFilesAssociatedWithPlanId($planId)
{

    $files = array();
    $files_associated = (array) TrainingPlan::findOrFail($planId)->files_associated;
    foreach ($files_associated as $file_id) {
        array_push($files, UserFile::findOrFail($file_id));
    }
    return $files;
}


/**
 * Returns the activity log of the current logged user within last 30 days. 
 */

function getLoggedInUserLog()
{
    $log = ActivityLog::where('isGroup', 0)
        ->where('entity_implied', Auth::user()->id)
        ->where(
            'created_at',
            '>=',
            Carbon::now()->subDays(30)->toDateTimeString()
        )->get();
    return $log;
}

/**
 * Returns an associative array containing user's wall.
 */
function getUserWall($userId)
{
    $json_decode = json_decode(User::findOrFail($userId)->my_wall, true);
    uasort($json_decode, function ($a, $b) {
        if ($a['position'] == $b['position']) return 0;
        return ($a['position'] < $b['position']) ? -1 : 1;
    });
    return $json_decode;
}
/**
 * Returns an associative array containing user's wall.
 */
function getUserWallElements($userId)
{
    return count(json_decode(User::findOrFail($userId)->my_wall, true));
}

/**
 * Returns a collection containing all groups where user belongs
 */
function getUserGroups()
{
    if (Auth::user()->isTrainer == 1) {
        return Auth::user()->trainer->groups;
    } else {




        return collect([]);
    }
}

/** Only for test -> DELETE */
function test2()
{
}


function test()
{
}
