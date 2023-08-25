<?php

namespace App\Http\Controllers;

use App\Models\Database;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latestData = Database::all();
        return response()->json($latestData);   
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
        // var_dump(json_encode($request));
        $db = new Database;
        $db->id_server = $request->id_server;
        $db->trafic = $request->trafic; 
        $db->save();
        // var_dump($cpu);
        return response()->json(['message' => 'Task created successfully', 'cpu' => $db]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $latestData = Database::where('id_server', $id) 
                    ->orderBy('id', 'desc')
                    ->limit(100)
                    ->get(); 
        return response()->json($latestData);
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
