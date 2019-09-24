<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\TimeLogRequest;
use App\Models\TimeLog;
use Illuminate\Http\Request;

class TimeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TimeLog::with(['created_by', 'user', 'ticket', 'project'])
                       ->orderby('id', 'asc')->paginate(100);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TimeLogRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(TimeLogRequest $request)
    {
        if( $request->validated()) {
            // store
            $row = new TimeLog();
            $row->ticket_id = $request->ticket_id;
            $row->project_id = $request->project_id;
            $row->user_id = $request->user_id;
            $row->created_by = $request->user()->id;
            $row->description = $request->description;
            $row->date = strtotime($request->date) > 0? date('Y-m-d', strtotime($request->date)): null;
            $row->time = strtotime($request->time) > 0? date('H:i:s', strtotime($request->time)): null;
            $row->hours = $request->hours;
            $row->minutes = $request->minutes;

            $row->save();

            return response()->json(["message"=>"Time log created successfully", 'data'=>$row->toArray()], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TimeLog  $timeLog
     * @return \Illuminate\Http\Response
     */
    public function show(TimeLog $timeLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TimeLog  $timeLog
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeLog $timeLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TimeLogRequest $request
     * @param  \App\TimeLog  $timeLog
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TimeLogRequest $request, TimeLog $timeLog)
    {
        if( $request->validated()) {
            // store
            $timeLog->ticket_id = $request->ticket_id;
            $timeLog->project_id = $request->project_id;
            $timeLog->user_id = $request->user_id;
            $timeLog->created_by = $request->user()->id;
            $timeLog->description = $request->description;
            $timeLog->date = strtotime($request->date) > 0? date('Y-m-d', strtotime($request->date)): null;
            $timeLog->time = strtotime($request->time) > 0? date('H:i:s', strtotime($request->time)): null;
            $timeLog->hours = $request->hours;
            $timeLog->minutes = $request->minutes;
            $timeLog->save();
            return response()->json(["message"=>"Time log updated successfully", 'data'=> $timeLog->toArray()], 202);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TimeLog  $timeLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeLog $timeLog)
    {
        $status = $timeLog->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Time Log Deleted!' : 'Error Deleting Time Log'
        ], 200);
    }

    public function summary($id, Request $request)
    {

    }
}
