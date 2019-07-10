<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assigned_to(){
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }
}
