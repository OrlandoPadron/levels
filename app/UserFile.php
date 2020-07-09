<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'file_name', 'extension', 'size', 'url', 'owned_by', 'shared_with',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'shared_with' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'owned_by');
    }
}
