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
        $db->usage_swap = $request->usage_swap; 
        $db->space_swap = $request->space_swap; 
        $db->created_at = Carbon::now(); 
        $db->updated_at = Carbon::now(); 
        $db->save();
        // var_dump($cpu);
        return response()->json(['message' => 'Task created successfully', 'memory' => $db]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    { 
        
        $id = $request->id;
        if($request->limit!=Null){
            $limit = $request->limit;
        }else{
            $limit = 10;
        }
        $inputDate = $request->date;
        if (Carbon::hasFormat($inputDate, 'Y-m-d')) {
            // return response()->json(['message' => 'Data tanggal valid, diproses.']);
            $currentTime = $inputDate;
        } else {
            // return response()->json(['message' => 'Format tanggal tidak valid.'], 400);
            $currentTime = Carbon::now();
            $currentTime = $currentTime->format('Y-m-d');
        } 
 
        $db = Memory::where('id_server', $id)
            ->whereDate('created_at', $currentTime) 
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();  

        return response()->json($db);
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
