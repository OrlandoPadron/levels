<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'created_by',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'users' => 'array',
        'files' => 'array',
        'admins' => 'array',
    ];


    public function creator()
    {
        return $this->belongsTo(Trainer::class, 'created_by');
    }

    public function threads()
    {
        return $this->hasMany(ForumThread::class, 'group_associated');
    }
}
