<?php

namespace App\Http\Middleware;

use App\Trainer;
use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CheckUserExists
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
        if (!isset($request->user)) return $next($request);

        try {
            User::findOrFail($request->user);
            //Athlete can only access his trainer's profile 
            if (!Auth::user()->isTrainer) {
                $trainerId = Auth::user()->athlete->trainer_id;
                if ($trainerId == null) return redirect('home');

                $trainer = Trainer::find($trainerId);
                if ($trainer->user->id != $request->user) return redirect('home');
            }
            return $next($request);
        } catch (ModelNotFoundException $ex) {
            return redirect('home');
        }
    }
}
