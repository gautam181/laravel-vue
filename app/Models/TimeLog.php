<?php

namespace App\Models;

use App\Models\Auth\User;
use App\Models\Project;
use App\Models\Ticket;
use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

class TimeLog extends Model
{
    private static $sort_options = [
        'user_name'=>['users.name'],
        'ticket_name'=>['tickets.title'],
        'date'=>['time_logs.date', 'time_logs.time']
    ];

    public static $columns= [
        'time_logs.*',
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
        $sort = ['time_logs.date'];
        if(isset(self::$sort_options[$val]))
            $sort = self::$sort_options[$val];
        return $sort;
    }

    /**
     * @param int $project_id
     * @param $params Request object
     *
     * @return mixed
     */
    public static function getTimesLog($project_id=0, $params)
    {
        $sort_by = strtolower($params->get('sortby'));
        $order_by = strtolower($params->get('orderby'));

        $timeslog = DB::table('time_logs')
            ->select(
                array_merge(['time_logs.*'], User::getColumns(), Project::getColumns(), Ticket::getColumns())
            )
            ->join('users', 'users.id', '=', 'time_logs.user_id')
            ->join('tickets', 'tickets.id', '=', 'time_logs.ticket_id');
            $timeslog->join('projects', 'projects.id', '=', 'time_logs.project_id');
        //$timeslog = self::with(['ticket', 'user']);
        if($project_id){
            $timeslog->where('time_logs.project_id', $project_id);
        }
        if($params->get('keyword')){
            $timeslog->where('time_logs.description', 'like', '%'.$params->keyword.'%');
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
        $assigned_to = $params->get('logged_by');
        if($assigned_to){
            $timeslog->whereIn('user_id', explode(',', $assigned_to));
        }
        foreach(self::getSortBy($sort_by) as $sort_val)
            $timeslog->orderby($sort_val, $order_by == 'asc'? 'asc': 'desc');

        return $timeslog->paginate(100);
    }

    /**
     * @param int $project_id
     * @param $params Request object
     *
     * @return mixed
     */
    public static function getTimeSummary($project_id=0, $params)
    {
        $timeslog = DB::table('time_logs')
                      ->select([
                          DB::raw('SUM(time_logs.hours) as loggedHours'),
                          DB::raw('SUM(time_logs.minutes) as loggedMinutes'),
                          DB::raw('SUM(time_logs.minutes) as estimatedHours'),
                          DB::raw('SUM(time_logs.minutes) as estimatedMinutes'),
                      ])
                      ->join('tickets', 'tickets.id', '=', 'time_logs.ticket_id');
        //$timeslog->join('projects', 'projects.id', '=', 'time_logs.project_id');
        //$timeslog = self::with(['ticket', 'user']);
        if($project_id){
            $timeslog->where('time_logs.project_id', $project_id);
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
        $assigned_to = $params->get('logged_by');
        if($assigned_to){
            $timeslog->whereIn('user_id', explode(',', $assigned_to));
        }
        $timeslog->groupBy('time_logs.project_id');

        return $timeslog->first();
    }

    public static function getSummaryByProject($id, $request)
    {
        $user_id = Auth::user()->id;
        $default =  [
            'mine' => 0,
            'everyone' => 0
        ];
        $data = [
            'logged'=> $default,
            'breakdown'=> [],
        ];
        //DB::enableQueryLog();
        $time_log = self::select([
            DB::raw('SUM(hours*60 + minutes) as everyone'),
            DB::raw('SUM(CASE WHEN user_id = "'.$user_id.'" THEN hours*60 + minutes ELSE 0 END) as mine')
        ])->where('project_id', $id)->groupby('project_id')->first();

        if($time_log)
            $data['logged'] = $time_log;

        $breakdown = self::with(['user'])->select([
            DB::raw('SUM(hours*60 + minutes) as minutes'),
            'user_id'
        ])->where('project_id', $id)->groupby('user_id')->get();

        if($breakdown)
            $data['breakdown'] = $breakdown;

        //print_r(DB::getQueryLog());

        return $data;
    }
}
