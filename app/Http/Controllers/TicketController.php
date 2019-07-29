<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Comment;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Ticket::with(['created_by', 'assigned_to', 'project'])
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
     * @param  TicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketRequest $request)
    {
        if( $request->validated()) {
            // store
            $ticket = new Ticket();
            $ticket->title = $request->title;
            $ticket->description = $request->description;
            $ticket->start_date = $request->start_date;
            $ticket->end_date = $request->end_date;
            $ticket->assigned_to = $request->assigned_to;
            $ticket->created_by = $request->user()->id;
            $ticket->project_id = $request->project_id;
            $ticket->save();

            return response()->json(["message"=>"Ticket created successfully", 'data'=>$ticket->toArray()], 201);
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
        return response()->json(Ticket::with(['created_by', 'assigned_to', 'project'])->findOrFail($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TicketRequest $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(TicketRequest $request, Ticket $ticket)
    {
        if( $request->validated()) {
            // store
            $ticket->title = $request->title;
            $ticket->description = $request->description;
            $ticket->start_date = $request->start_date;
            $ticket->end_date = $request->end_date;
            $ticket->assigned_to = $request->assigned_to;
            $ticket->project_id = $request->project_id;
            $ticket->save();

            return response()->json(["message"=>"Ticket updated successfully", 'data'=> $ticket->toArray()], 202);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $status = $ticket->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'Project Deleted!' : 'Error Deleting Project'
        ], 200);
    }

    public function comments($id)
    {
        return response()->json(Comment::with(['created_by'])->where('ticket_id', $id)->orderby('id', 'asc')->paginate(100), 200);
    }
}
