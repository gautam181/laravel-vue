<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Ticket;
use App\Models\TimeLog;
use Validator;
use DB;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Project::getProjects($request);
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
     * @param ProjectRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProjectRequest $request)
    {
       if( $request->validated()) {
            // store
            $project = new Project();
            $project->name = $request->name;
            $project->description = $request->description;
            $project->start_date = strtotime($request->start_date) > 0? date('Y-m-d', strtotime($request->start_date)): null;
            $project->end_date = strtotime($request->end_date) > 0? date('Y-m-d', strtotime($request->end_date)) : null;
            $project->owner = $request->owner;
            $project->progress = $request->progress;
            $project->created_by = $request->user()->id;
            $project->save();

            return response()->json(["message"=>"Project created successfully", 'data'=>$project->toArray()], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return response()->json(Project::with(['created_by', 'owner'])->findOrFail($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        if( $request->validated()) {
            // store
            $project->name = $request->name;
            $project->description = $request->description;
            $project->start_date = strtotime($request->start_date) > 0? date('Y-m-d', strtotime($request->start_date)): null;
            $project->end_date = strtotime($request->end_date) > 0? date('Y-m-d', strtotime($request->end_date)) : null;
            $project->owner = $request->owner;
            $project->progress = $request->progress;
            $project->save();

            return response()->json(["message"=>"Project updated successfully", 'data'=> $project->toArray()], 202);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $status = $project->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Project Deleted!' : 'Error Deleting Project'
        ], 200);
    }

    /**
     * get ticket for a project
     *
     * @param $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function tickets($id, Request $request){
        $data = Ticket::getTickets($id, $request);
        return response()->json($data);
    }

    public function timeLog($id, Request $request){
        $data = TimeLog::getTimesLog($id, $request);
        return response()->json($data);
    }
    /**
     * @param $id project id
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function completed($id)
    {
        $project = Project::with(['created_by', 'owner'])->findOrFail($id);
        $project->progress = 100;
        $project->status = 1;
        $project->save();

        return response()->json(["message"=>"Project completed successfully", 'data'=> $project->toArray()], 202);
    }
}
