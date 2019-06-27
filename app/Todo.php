<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = ['title', 'completed', 'date', 'time', 'user_id'];
    protected $hidden = ['created_at', 'updated_at'];
}
