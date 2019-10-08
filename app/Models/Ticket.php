<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Auth;

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

    public static function getSummaryByProject($id, $request)
    {
        //DB::enableQueryLog();
        $today = date('Y-m-d');
        $user_id = Auth::user()->id;
        $default =  [
            'late' => 0,
            'today' => 0,
            'upcoming' => 0,
            'nodate' => 0,
        ];
        $data = [
            'mine'=> $default,
            'everyone'=> $default,
        ];
        $tickets = self::select([
            DB::raw('SUM(CASE WHEN end_date < "'.$today.'" THEN 1 ELSE 0 END) as late'),
            DB::raw('SUM(CASE WHEN end_date = "'.$today.'" THEN 1 ELSE 0 END) as today'),
            DB::raw('SUM(CASE WHEN end_date > "'.$today.'" THEN 1 ELSE 0 END) as upcoming'),
            DB::raw('SUM(CASE WHEN end_date is null THEN 1 ELSE 0 END) as nodate'),
        ]);

        $all = $tickets->where('project_id', $id)->groupBy('project_id')->first();

        $mine = $tickets->where('project_id', $id)->where('assigned_to', $user_id)->groupBy('project_id')->first();
        //print_r(DB::getQueryLog());
        if($all)
            $data['everyone'] = $all;
        if($mine)
            $data['mine'] = $mine;
        return $data;
    }
}
