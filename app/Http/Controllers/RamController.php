<?php

namespace App\Http\Controllers;

use App\Models\Ram;
use Illuminate\Http\Request;

class RamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $getRam = Ram::all();
        
        return response()->json($getRam);
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
        $db = new Ram;
        $db->id_server = $request->id_server;
        $db->usage_ram = $request->usage_ram; 
        $db->space_ram = $request->space_ram; 
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
