<?php

namespace App\Http\Controllers;

use App\Models\Temperature;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TemperatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $temp = Temperature::all();

        return response()->json($temp);
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
        $temp = new Temperature;
        $temp->id_user = $request->id_user;
        $temp->id_server = $request->id_server;
        $temp->temp = $request->temp;
        $temp->save();

        return response()->json(['message' => 'Task created successfully', 'temp' => $temp]);
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
        
        
        $latestData = Temperature::where('id_server', $id) 
                    ->whereDate('created_at', $currentTime) 
                    ->orderBy('id', 'desc')
                    ->limit($limit)
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
