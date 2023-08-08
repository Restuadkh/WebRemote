<?php

namespace App\Http\Controllers;

use App\Models\Cpu;
use App\Models\Server;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $server = Server::get();
        return view('home',compact('server'));
    }

    public function show(string $id){
        $cpu = Cpu::where('id_server', $id)->latest()->first(); 
        return view("SelectionServer", compact('cpu'));
    }
    public function get(string $id){
        $cpu = Cpu::where('id_server', $id)->latest()->first();
         
        return response()->json($cpu);
    }
}
