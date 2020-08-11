<?php

use App\User;
use App\Group;
use App\Athlete;
use App\Trainer;
use App\UserFile;
use App\ActivityLog;
use App\ForumThread;
use App\TrainingPlan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Mockery\Undefined;

use function GuzzleHttp\json_decode;

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
function getArrayOfUsersTrainedByMe()
{
    $users = array();
    $trainer = Trainer::findOrFail(Auth::user()->trainer->id);
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

function getAllTrainersAsUsers()
{
    return User::where('isTrainer', '1')->get();
}


/**
 * Given a group, function returns all group members as User Model array. 
 */
function getGroupUsers($groupId)
{
    $group = Group::findOrFail($groupId);
    $usersId = $group->users;

    $group_members = collect();
    $group_members->add($group->creator->user);

    if (empty($usersId)) return $group_members;

    foreach ($usersId as $id) {
        $group_members->add(User::findOrFail($id));
    }
    return $group_members;
}


function getUserRole($groupId, $userId)
{
    $group = Group::findOrFail($groupId);
    $admins = $group->admins;
    if ($group->creator->user->id == $userId) {
        return 'Propietario';
    } elseif (in_array($userId, $admins)) {
        return 'Administrador';
    } else {
        return 'Miembro';
    }
}


function isUserMemberOfThisGroup($groupId, $userId)
{
    $groupMembers = (array) Group::find($groupId)->users;
    if (in_array($userId, $groupMembers)) {
        return true;
    } else {
        return false;
    }
}

function getUsersTrainedByMeWhoArentInTheGroupYet($groupId)
{
    $users = getArrayOfUsersTrainedByMe();
    $users_not_in_group = collect();

    foreach ($users as $user) {
        if (!isUserMemberOfThisGroup($groupId, $user->id)) $users_not_in_group->add($user);
    }

    return $users_not_in_group;
}

function getAllTrainersWhoArentInThisGroupYet($groupId)
{
    $users = getAllTrainersAsUsers();
    $trainers_not_in_group = collect();

    foreach ($users as $user) {
        if ($user->id != Auth::user()->id) {
            if (!isUserMemberOfThisGroup($groupId, $user->id)) $trainers_not_in_group->add($user);
        }
    }

    return $trainers_not_in_group;
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
function getFilesNotSharedWithGroup($userLoggedInId, $groupId)
{
    $groupFiles = (array) Group::findOrFail($groupId)->files;
    $userFiles = UserFile::where('owned_by', $userLoggedInId)->get();
    $filesNotSharedWithGroup = collect();

    foreach ($userFiles as $file) {
        if (!in_array($file->id, $groupFiles)) $filesNotSharedWithGroup->add($file);
    }
    return $filesNotSharedWithGroup;
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

function getUserLog($id)
{
    $log = ActivityLog::where('isGroup', 0)
        ->where('entity_implied', $id)
        ->where(
            'created_at',
            '>=',
            Carbon::now()->subDays(30)->toDateTimeString()
        )->get();
    return $log;
}

function getGroupLog($group_id)
{
    return ActivityLog::where('isGroup', 1)
        ->where('entity_implied', $group_id)
        ->where(
            'created_at',
            '>=',
            Carbon::now()->subDays(30)->toDateTimeString()
        )->get();
}


function getGroupFiles($group_id)
{

    $arrayFilesId = (array) Group::findOrFail($group_id)->files;
    $files = array();
    foreach ($arrayFilesId as $id) {
        array_push($files, UserFile::findOrFail($id));
    }
    return $files;
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
        return Group::where('users', 'like', "%" . Auth::user()->id . "%")->get();
    }
}

function getFileModelGivenItsId($file_id)
{
    return UserFile::findOrFail($file_id);
}


function getThreadGivenItsId($thread_id)
{
    return ForumThread::findOrFail($thread_id);
}
/** Only for test -> DELETE */
function test2()
{
}


function test()
{
}
