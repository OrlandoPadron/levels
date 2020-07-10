<?php

use App\User;
use App\Group;
use App\Athlete;
use App\Trainer;
use App\UserFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;


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

/**
 * Returns trainers name given a trainer_id. 
 */
function getTrainersNameByTrainerId($trainer_id)
{
    $trainer = Trainer::find($trainer_id)->user;
    return $trainer->name . ' ' . $trainer->surname;
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
    foreach ($trainer->trained_by_me as $trainer_id) {
        array_push($users, getUserUsingAthleteId($trainer_id));
    }
    return $users;
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
