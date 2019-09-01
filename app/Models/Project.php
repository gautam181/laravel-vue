<?php

namespace App\Models;

use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DB;

class Project extends Model
{
    //

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
        if($params->get('keyword')){
            $projects->where('name', 'like', '%'.$params->keyword.'%');
            $projects->orwhere('description', 'like', '%'.$params->keyword.'%');
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
            $projects->where('owner', $owner);
        }
        $projects->orderby('updated_at', 'desc');
        return $projects->paginate(30);
    }
}
