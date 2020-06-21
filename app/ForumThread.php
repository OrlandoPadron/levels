<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumThread extends Model
{
    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'thread_id');
    }

    public function model()
    {
        if ($this->user_associated != null) {
            return $this->belongsTo(User::class);
        }
        if ($this->group_associated != null) {
            return $this->belongsTo(Group::class);
        }
    }
}
