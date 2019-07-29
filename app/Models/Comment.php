<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
