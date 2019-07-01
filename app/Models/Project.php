<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'owner');
    }
}
