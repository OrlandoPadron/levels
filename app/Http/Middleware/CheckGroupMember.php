<?php

namespace App\Http\Middleware;

use Closure;
use App\Group;
use Illuminate\Support\Facades\Auth;

class CheckGroupMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!isUserMemberOfThisGroup($request->group, Auth::user()->id)) {
            return redirect('home');
        }

        return $next($request);
    }
}
