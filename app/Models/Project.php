<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title', 'description', 'user_id'];

    public function userStories()
    {
        return $this->hasMany(UserStory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}