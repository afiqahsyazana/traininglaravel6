<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function user()
    {
        //to initiate task is belong to user
       return $this->belongsTo(User::class); 
    }
        
}
