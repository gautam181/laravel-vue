<?php

namespace App\Http\Controllers;

use App\Models\Auth\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $data = User::select(['id', 'name', 'email'])
                      ->orderby('name', 'asc')->get();
        return response()->json($data);
    }
}
