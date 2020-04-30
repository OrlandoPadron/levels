<?php

use Illuminate\Support\Facades\Request;


function setActive($tab)
{
    if ($tab == "general") {
        return request()->routeIs('profile.show') ? 'active-dashboard' : '';
    }
    return Request::get('tab') == $tab ? 'active-dashboard' : '';
}
