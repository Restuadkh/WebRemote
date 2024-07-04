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
        return view('home', compact('server'));
    }

    public function show(string $id)
    {
        $cpu = Cpu::where('id_server', $id)->latest()->first();
        return view("SelectionServer", compact('cpu'));
    }
    public function get(string $id)
    {
        $cpu = Cpu::where('id_server', $id)->latest()->first();

        return response()->json($cpu);
    }

    public function ping($ip) // Test Response Ping
    {
        // $ip = "103.180.196.140";
        $ping = exec("ping -n 1 $ip", $output, $status);
        try {
            if (preg_match('/time[=<](\d+ms)/', $output[2], $matches)) {
                // Ganti '<' dengan '=' jika ada
                $result = str_replace('<', '=', $matches[1]);
                return response()->json(["Status", true, "Response", $matches[1]]);
            } else {
                return response()->json(["Status", false, "Error", "Request Time Out"]);
            }
        } catch (\Exception $e) {
            return response()->json(["Status", false, "Error", "Ping request could not find host $ip"]);
        }
    }

    public function http($url)
    {
        // $url = "https://google.com";
        $ch = curl_init($url);

        // Set options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_HEADER, true); // Include the header in the output
        curl_setopt($ch, CURLOPT_NOBODY, true); // We don't need the body
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Don't verify SSL certificate (not recommended for production)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Don't verify SSL host (not recommended for production)

        // Start the timer
        $start = microtime(true);

        // Execute the request
        curl_exec($ch);

        // Stop the timer
        $end = microtime(true);

        // Calculate the response time
        $responseTime = ($end - $start) * 1000; // Convert to milliseconds

        // Close the cURL session
        curl_close($ch);

        // return $responseTime . 'ms'; 
        return response()->json(["Status", true, "Response", "URL", $url, "$responseTime" . "ms"]);
    }
}
