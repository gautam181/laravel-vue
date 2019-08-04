<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  CommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        if( $request->validated()) {
            // store
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->ticket_id = $request->ticket_id;
            $comment->project_id = $request->project_id;
            $comment->created_by = $request->user()->id;
            $comment->save();

            return response()->json(["message"=>"Comment created successfully", 'data'=>$comment->toArray()], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CommentRequest  $request
     * @param  Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        if( $request->validated()) {
            // store
            $comment->comment = $request->comment;
            $comment->ticket_id = $request->ticket_id;
            $comment->project_id = $request->project_id;
            $comment->created_by = $request->user()->id;
            $comment->save();

            return response()->json(["message"=>"Comment updated successfully", 'data'=>$comment->toArray()], 202);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }

}
