<?php

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
function currentlyTrainingAthlete($athlete_id)
{
    $athletes_trained = (array) Auth::user()->trainer->trained_by_me;
    if (in_array($athlete_id, $athletes_trained)) {
        return true;
    } else {
        return false;
    }
}
