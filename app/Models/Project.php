<?php

namespace App\Models;

use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model
{
    //
    private static $sort_options = [
        'id' => 'id', 'name'=>'name', 'created_date'=>'created_at',
        'due_date'=>'end_date', 'start_date'=>'start_date', 'update_date'=>'updated_at'
        ];

    public static function getSortBy($val ='')
    {
        $sort = 'updated_at';
        if(isset(self::$sort_options[$val]))
            $sort = self::$sort_options[$val];
        return $sort;
    }
    public function created_by(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'owner');
    }

    public static function getProjects($params)
    {
        DB::enableQueryLog();
        $projects = self::with(['created_by', 'owner']);
        if($params->has('completed')) {
            $projects->where('status', $params->get('completed'));
        }
        if($params->get('keyword')){
            $projects->where(function ($q) use ($params){
                $q->where('name', 'like', '%'.$params->keyword.'%')
                  ->orwhere('description', 'like', '%'.$params->keyword.'%');
            });
            //$projects->where('name', 'like', '%'.$params->keyword.'%')->orwhere('description', 'like', '%'.$params->keyword.'%');
        }
        if($params->has('created_range') && $params->has('start_date') && $params->has('end_date')){
            if($params->created_range == 1 && $params->start_date && $params->end_date){
                $start_date = date('Y-m-d', strtotime($params->start_date));
                $end_date = date('Y-m-d', strtotime($params->end_date));
                $projects->whereBetween('created_at', [$start_date, $end_date]);
            }

        }
        $due_date_range = $params->get('due_date_range');
        if($due_date_range > 0){
            if($due_date_range == 1){
                $projects->whereNull('end_date');
            }
            else if($due_date_range == 2){
                $projects->whereNull('start_date');
            }
            else if($due_date_range == 3){
                $projects->whereNull('start_date')->orWhereNull('end_date');
            }
            else {
                if($due_date_range == 4 && $params->get('due_start_date') && $params->get('due_end_date')){
                    $start_date = date('Y-m-d', strtotime($params->due_start_date));
                    $end_date = date('Y-m-d', strtotime($params->due_end_date));
                    $projects->whereBetween('end_date', [$start_date, $end_date]);
                }
            }
        }
        $owner = $params->get('owner');
        if($owner){
            $projects->whereIn('owner', explode(',', $owner));
        }
        $sort_by = strtolower($params->get('sortby'));
        $order_by = strtolower($params->get('orderby'));
        $projects->orderby(self::getSortBy($sort_by), $order_by == 'asc'? 'asc': 'desc');
        return $projects->paginate(30);
    }

    public static function getColumns()
    {
        return ['projects.name as project_name', 'projects.status as project_status'];
    }
}
