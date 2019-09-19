<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function user(){
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class, 'Ticket_id');
    }
}
