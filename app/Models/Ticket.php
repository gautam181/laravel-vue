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

    public static function getTickets($project_id=0, $params)
    {
        $tickets = self::with(['assigned_to', 'project']);
        if($project_id){
            $tickets->where('project_id', $project_id);
        }
        if($params->get('keyword')){
            $tickets->where('title', 'like', '%'.$params->keyword.'%');
            $tickets->orwhere('description', 'like', '%'.$params->keyword.'%');
        }
        if($params->has('created_range') && $params->has('start_date') && $params->has('end_date')){
            if($params->created_range == 1 && $params->start_date && $params->end_date){
                $start_date = date('Y-m-d', strtotime($params->start_date));
                $end_date = date('Y-m-d', strtotime($params->end_date));
                $tickets->whereBetween('created_at', [$start_date, $end_date]);
            }

        }
        $due_date_range = $params->get('due_date_range');
        if($due_date_range > 0){
            if($due_date_range == 1){
                $tickets->whereNull('end_date');
            }
            else if($due_date_range == 2){
                $tickets->whereNull('start_date');
            }
            else if($due_date_range == 3){
                $tickets->whereNull('start_date')->orWhereNull('end_date');
            }
            else {
                if($due_date_range == 4 && $params->get('due_start_date') && $params->get('due_end_date')){
                    $start_date = date('Y-m-d', strtotime($params->due_start_date));
                    $end_date = date('Y-m-d', strtotime($params->due_end_date));
                    $tickets->whereBetween('end_date', [$start_date, $end_date]);
                }
            }
        }
        $assigned_to = $params->get('assigned_to');
        if($assigned_to){
            $tickets->whereIn('assigned_to', explode(',', $assigned_to));
        }
        $tickets->orderby('updated_at', 'desc');
        return $tickets->paginate(100);
    }

    public static function getColumns()
    {
        return ['tickets.title as ticket_name'];
    }
}
