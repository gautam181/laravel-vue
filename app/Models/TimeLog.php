<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    //

    public function created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class, 'Ticket_id');
    }
}
