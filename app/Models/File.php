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

    public static function getColumns()
    {
        return ['files.knownas as file_name','files.filename as file_path', 'files.size as file_size'];
    }
}
