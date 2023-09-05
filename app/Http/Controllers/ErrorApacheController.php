<?php

namespace App\Http\Controllers;

use App\Models\ErrorApache;
use Illuminate\Http\Request;

class ErrorApacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $get = ErrorApache::all();

        return response()->json($get);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 
        $create = new ErrorApache();
        $create->id_user = $request->id_user;
        $create->id_server = $request->id_server;
        $create->datetime = $request->datetime;
        $create->status = $request->status; 
        $create->save();

        return response()->json(['message' => 'Task created successfully', 'create' => $create]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
