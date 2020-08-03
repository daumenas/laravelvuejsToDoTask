<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToDoTask extends Model
{
    protected $fillable = [
        'name', 'description', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::Class, 'user_id');
    }
}
