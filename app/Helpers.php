<?php

use App\User;
use App\Athlete;
use App\Trainer;
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

function getAthleteById($id)
{
    $user = Athlete::find($id)->user;
    return $user;
}
