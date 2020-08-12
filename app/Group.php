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

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'users' => '[]',
        'files' => '[]',
        'admins' => '[]',
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
