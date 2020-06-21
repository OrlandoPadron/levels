<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Symfony\Component\HttpKernel\Profiler\Profile;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password',
        'isTrainer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'isTrainer' => false,
        'admin' => false,
    ];


    public function trainer()
    {
        if ($this->isTrainer == 1) {
            return $this->hasOne(Trainer::class);
        }
    }

    public function athlete()
    {
        if ($this->isTrainer == 0) {
            return $this->hasOne(Athlete::class);
        }
    }

    public function threads()
    {
        return $this->hasMany(ForumThread::class, 'user_associated');
    }
}
