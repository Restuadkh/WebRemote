<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MemoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $db = Memory::all();

        return response()->json($db);

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
        $db = new Memory;
        $db->id_user = $request->id_user;
        $db->id_server = $request->id_server;
        $db->usage_ram = $request->usage_ram; 
        $db->space_ram = $request->space_ram; 
        $db->created_at = Carbon::now(); 
        $db->updated_at = Carbon::now(); 
        $db->save();
        // var_dump($cpu);
        return response()->json(['message' => 'Task created successfully', 'cpu' => $db]);
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
