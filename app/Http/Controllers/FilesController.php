<?php

namespace App\Http\Controllers;

use App\Models\Files;
use Illuminate\Http\Request;

class FilesController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputfile = $request->file('file');
        $path = $request->file('file')->store('files/'.$request->project_id);
        $file = new Files();
        $file->filename = $path;
        $file->project_id= $request->project_id;
        $file->ticket_id = $request->ticket_id;
        $file->knownas = $inputfile->getClientOriginalName();
        $file->size = $inputfile->getSize();
        $file->description = $request->description;
        $file->uploaded_by = $request->user()->id;
        $file->save();

        return $path;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function show(Files $files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function edit(Files $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Files $files)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function destroy(Files $files)
    {
        //
    }

    public function detail(Request $request, $id)
    {
        Files::where('id', $id)->update([
            'knownas' => $request->knownas,
            'description' => $request->description
        ]);

        return response()->json(["message"=>"File details updated successfully", 'data'=> $request->toArray()], 202);
    }
}
