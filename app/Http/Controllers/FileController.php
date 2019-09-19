<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
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
        $path = $request->file('file')->store('files/'.$request->project_id.'-'.$request->ticket_id);
        $file = new File();
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
     * @param  \App\Models\File $file
     *
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $files
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(File $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\File  $file
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\File  $file
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        Storage::delete($file->filename);
        $status = $file->delete();

        return response()->json([
            'status' => $status,
            'message' => $status ? 'File Deleted!' : 'Error Deleting File'
        ], 200);
    }

    public function detail(Request $request, $id)
    {
        File::where('id', $id)->update([
            'knownas' => $request->knownas,
            'description' => $request->description
        ]);

        return response()->json(["message"=>"File details updated successfully", 'data'=> $request->toArray()], 202);
    }
}
