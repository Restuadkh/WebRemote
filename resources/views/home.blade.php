@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center"> 
        @foreach ($server as $data_server)
        <div class="col-3 m-1">
            <div class="card">
                <div class="card-header">{{ $data_server->NamaServer }}</div>
                <div class="card-body">
                    <h4 class="card-title">{{ $data_server->IPServer }}</h4>
                    <p class="card-text">{{ $data_server->DescriptionServer }}</p>
                    <p class="card-text" id="ID_Server">{{ $data_server->id }}</p>
                    <p>Data yang akan diperbarui: 
                    <div  id='data-container'></div></p>
                </div>
                <div class="card-footer">
                    <a href="{{ route('home.show', ['id' => $data_server->id]) }}" class="btn btn-primary">more</a>
                </div>
            </div>
        </div>         
        @endforeach
        
        
    </div>
</div>
@endsection
