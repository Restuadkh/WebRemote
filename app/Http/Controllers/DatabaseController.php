<?php

namespace App\Http\Controllers;

use App\Models\Database;
use App\Models\Proseslist;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        $db->created_at = Carbon::now(); 
        $db->updated_at = Carbon::now(); 
        $db->save();
        // var_dump($cpu);
        return response()->json(['message' => 'Task created successfully', 'db' => $db]);
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
        
        
        $latestData = Database::where('id_server', $id) 
                    ->whereDate('created_at', $currentTime) 
                    ->orderBy('id', 'desc')
                    ->limit($limit)
                    ->get();  

        return response()->json($latestData);
    }

    public function get(string $id)
    {
        $latestData = Database::where('id_server', $id) 
                    ->orderBy('id', 'desc')
                    ->limit(1)
                    ->get(); 
        return response()->json($latestData);
    }

    public function test(Request $request)
    {   
        $jsonData = $request->json()->all();
        var_dump($jsonData);
        return response()->json($jsonData);
    }

    public function showProcessList(Request $request)
    {
        // $processList = DB::select('SHOW PROCESSLIST');
        $processList = DB::connection('otherdb')->select('SHOW PROCESSLIST');
        $count = DB::connection('otherdb')->select("
        SELECT db, COUNT(*) AS jumlah_proses
        FROM information_schema.processlist
        GROUP BY db;
        ");

        foreach ($count as $row) {
            $countdb = new Proseslist; 
            $countdb->id_user = "2";
            $countdb->id_server = "4";
            $countdb->db = $row->db;
            $countdb->count = $row->jumlah_proses;
            $countdb->save();
        }

        return response()->json($count); 
        
        // return view('db', ['processList' => $processList]);

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
