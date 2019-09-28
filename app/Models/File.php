<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    private static $sort_options = [
        'name'=>'knownas',
        'updated'=>'updated_at',
        'size'=>'size'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function project(){
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function ticket(){
        return $this->belongsTo(Ticket::class, 'Ticket_id');
    }
    public static function getSortBy($val ='')
    {
        $sort = 'created_at';
        if(isset(self::$sort_options[$val]))
            $sort = self::$sort_options[$val];
        return $sort;
    }

    public static function getFiles($project_id=0, $params)
    {
        $sort_by = strtolower($params->get('sortby'));
        $order_by = strtolower($params->get('orderby'));

        $files = self::with(['user', 'project']);
        if($project_id){
            $files->where('project_id', $project_id);
        }
        if($params->get('keyword')){
            $files->where('knownas', 'like', '%'.$params->keyword.'%');
            $files->orwhere('description', 'like', '%'.$params->keyword.'%');
        }
        if($params->has('created_range') && $params->has('start_date') && $params->has('end_date')){
            if($params->created_range == 1 && $params->start_date && $params->end_date){
                $start_date = date('Y-m-d', strtotime($params->start_date));
                $end_date = date('Y-m-d', strtotime($params->end_date));
                $files->whereBetween('created_at', [$start_date, $end_date]);
            }

        }

        $assigned_to = $params->get('uploaded_by');
        if($assigned_to){
            $files->whereIn('uploaded_by', explode(',', $assigned_to));
        }

        $files->orderby(self::getSortBy($sort_by), $order_by == 'asc'? 'asc': 'desc');

        return $files->paginate(100);
    }
    public static function getColumns()
    {
        return ['files.knownas as file_name','files.filename as file_path', 'files.size as file_size'];
    }
}
