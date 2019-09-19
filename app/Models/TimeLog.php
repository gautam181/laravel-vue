<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    private static $sort_options = [
        'logged_by'=>'user_id',
        'ticket'=>'ticket_id',
        'date'=>'date'
    ];

    public function created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public static function getSortBy($val ='')
    {
        $sort = 'updated_at';
        if(isset(self::$sort_options[$val]))
            $sort = self::$sort_options[$val];
        return $sort;
    }

    public static function getTimesLog($project_id=0, $params)
    {
        $sort_by = strtolower($params->get('sortby'));
        $order_by = strtolower($params->get('orderby'));
        $order = true;
        if($sort_by == 'name'){
            $timeslog = self::with(['ticket', 'user'=>function($query){
                $query->orderBy('name', 'asc');
            }]);
            $order= false;
        } else
            $timeslog = self::with(['ticket', 'user']);
        if($project_id){
            $timeslog->where('project_id', $project_id);
        }
        if($params->get('keyword')){
            $timeslog->where('title', 'like', '%'.$params->keyword.'%');
            $timeslog->orwhere('description', 'like', '%'.$params->keyword.'%');
        }
        if($params->has('created_range') && $params->has('start_date') && $params->has('end_date')){
            if($params->created_range == 1 && $params->start_date && $params->end_date){
                $start_date = date('Y-m-d', strtotime($params->start_date));
                $end_date = date('Y-m-d', strtotime($params->end_date));
                $timeslog->whereBetween('created_at', [$start_date, $end_date]);
            }

        }
        $due_date_range = $params->get('due_date_range');
        if($due_date_range > 0){
            if($due_date_range == 1){
                $timeslog->whereNull('end_date');
            }
            else if($due_date_range == 2){
                $timeslog->whereNull('start_date');
            }
            else if($due_date_range == 3){
                $timeslog->whereNull('start_date')->orWhereNull('end_date');
            }
            else {
                if($due_date_range == 4 && $params->get('due_start_date') && $params->get('due_end_date')){
                    $start_date = date('Y-m-d', strtotime($params->due_start_date));
                    $end_date = date('Y-m-d', strtotime($params->due_end_date));
                    $timeslog->whereBetween('end_date', [$start_date, $end_date]);
                }
            }
        }
        $assigned_to = $params->get('assigned_to');
        if($assigned_to){
            $timeslog->whereIn('assigned_to', explode(',', $assigned_to));
        }
        if($order)
            $timeslog->orderby(self::getSortBy($sort_by), $order_by == 'asc'? 'asc': 'desc');
        return $timeslog->paginate(100);
    }
}
