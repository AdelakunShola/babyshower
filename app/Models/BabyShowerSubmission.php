<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BabyShowerSubmission extends Model
{
    protected $fillable = ['name', 'email', 'guess', 'video_path', 'message'];
}