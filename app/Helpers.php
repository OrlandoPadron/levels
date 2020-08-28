<?php

use App\User;
use App\Group;
use App\Athlete;
use App\Trainer;
use App\UserFile;
use App\ActivityLog;
use App\ForumThread;
use App\TrainingPlan;
use Mockery\Undefined;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\json_decode;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

function getGroupById($groupId)
{
    return Group::findOrFail($groupId);
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
    try {
        $group = Group::findOrFail($groupId);
    } catch (ModelNotFoundException $ex) {
        return false;
    }
    $groupMembers = (array) $group->users;
    if (in_array($userId, $groupMembers)) {
        return true;
    } else {
        //Check if user is group creator
        if ($group->creator->user->id == $userId) {
            return true;
        } else {
            return false;
        }
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
        ->where('file_type', 0)
        ->where('shared_with', 'not like', "%\"$userId\"%")
        ->get();
    return $files;
}
function getFilesNotSharedWithGroup($userLoggedInId, $groupId)
{
    $groupFiles = (array) Group::findOrFail($groupId)->files;
    $userFiles = UserFile::where('owned_by', $userLoggedInId)
        ->where('file_type', 0)->get();
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
        $groups = Auth::user()->trainer->groups;
        return $groups->merge(Group::where('users', 'like', "%" . Auth::user()->id . "%")->get());
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


/** Save log entry into ActivityLogController */
function saveActivityLog($logArray)
{
    $logController = new ActivityLogController();
    $logController->store($logArray);
}

/**
 * Function that returns the count of plan changes Auth user hasn't seen yet. 
 * Used in order to represent a visual indicator in userbar's section "Planes de entrenamiento". 
 */
function numOfPlansAssociatedWithUserIHaventSeen($userId, $notificationArray)
{
    $count = 0;
    $trainingPlans = $notificationArray;
    $user = User::findOrFail($userId);

    if ($user->isTrainer) return 0;

    array_pop($trainingPlans); //Getting rid of 'totalChanges' element. 
    foreach ($trainingPlans as $trainingPlan) {
        $athlete = Athlete::findOrFail(reset($trainingPlan)->athleteAssociated->id);
        if ($athlete->id == $user->athlete->id) {
            $count++;
        }
    }
    return $count;
}

/** Returns true if the training plan hasn't been seen by user after a file update */
function haventISeenThisPlan($planId, $notificationArray)
{
    $trainingPlans = $notificationArray;
    array_pop($trainingPlans); //Getting rid of 'totalChanges' element. 
    foreach ($trainingPlans as $trainingPlan) {
        if (reset($trainingPlan)->id == $planId) {
            return true;
        }
    }
    return false;
}

function haventISeenThisFile($fileId, $notificationArray)
{
    $trainingPlans = $notificationArray;
    array_pop($trainingPlans); //Getting rid of 'totalChanges' element. 
    foreach ($trainingPlans as $trainingPlan) {
        foreach (end($trainingPlan) as $idOfFile) {
            if ($fileId == $idOfFile) {
                return true;
            }
        }
    }
    return false;
}
function haventISeenThisThread($threadId, $notificationArray)
{
    $threads = $notificationArray;
    array_pop($threads); //Getting rid of 'totalChanges' element. 
    foreach ($threads as $thread_Id => $thread) {
        if ($threadId == $thread_Id) {
            return true;
        }
    }
    return false;
}

function haventISeenThisGroupThread($threadId, $notificationArray)
{
    $group = $notificationArray;
    array_pop($group); //Getting rid of 'totalChanges' element. 
    foreach ($group as $groupId => $threads) {
        foreach ($threads as $thread_Id => $thread) {
            if ($threadId == $thread_Id) {
                return true;
            }
        }
    }
    return false;
}
