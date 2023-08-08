<?php

namespace App\Http\Controllers;

use App\Models\Cpu;
use Illuminate\Http\Request;

class CpuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $latestData = Cpu::all();
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
        $cpu = new Cpu;
        $cpu->id_server = $request->id_server;
        $cpu->usage_cpu = $request->usage_cpu;
        $cpu->core_cpu = $request->core_cpu;
        $cpu->save();
        // var_dump($cpu);
        return response()->json(['message' => 'Task created successfully', 'cpu' => $cpu]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $latestData = Cpu::where('id_server', $id)->orderBy('id', 'desc')->first();
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
