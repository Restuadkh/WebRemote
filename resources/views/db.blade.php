@extends('layouts.app')

@section('content')
<h1>Daftar Proses Database</h1>
    
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Host</th>
            <th>Database</th>
            <th>Command</th>
            <th>Time</th>
            <th>State</th>
            <th>Info</th>
        </tr>
    </thead>
    <tbody>
        @foreach($processList as $process)
            <tr>
                <td>{{ $process->Id }}</td>
                <td>{{ $process->User }}</td>
                <td>{{ $process->Host }}</td>
                <td>{{ $process->db }}</td>
                <td>{{ $process->Command }}</td>
                <td>{{ $process->Time }}</td>
                <td>{{ $process->State }}</td>
                <td>{{ $process->Info }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
