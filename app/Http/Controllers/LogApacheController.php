<?php

namespace App\Http\Controllers;

use App\Models\LogApache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogApacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $get = LogApache::all();

        return response()->json($get);
        // return response()->json(['message' => 'Task created successfully']);

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
        $create = new LogApache;
        $create->id_user = $request->id_user;
        $create->id_server = $request->id_server;
        $create->datetime = $request->datetime;
        $create->host = $request->host;
        $create->method = $request->method;
        $create->uri = $request->uri;
        $create->status = $request->status;
        $create->bytes = $request->bytes;
        $create->user_agent = $request->user_agent;
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
