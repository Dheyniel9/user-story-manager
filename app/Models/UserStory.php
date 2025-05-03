<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    protected $fillable = ['title', 'description', 'status', 'priority'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
