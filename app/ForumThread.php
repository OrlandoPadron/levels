<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'author', 'user_associated', 'group_associated',
    ];

    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'thread_id');
    }

    public function model()
    {
        if ($this->user_associated != null) {
            return $this->belongsTo(User::class, 'user_associated');
        }
        if ($this->group_associated != null) {
            return $this->belongsTo(Group::class, 'group_associated');
        }
    }
}
