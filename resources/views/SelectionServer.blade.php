@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">   
        <div class="col-md m-1">
            <div class="card">
                <div class="card-header">{{ $cpu->id }}</div>
                <div class="card-body">
                    <h4 class="card-title">{{ $cpu->id_server }}</h4>
                    <p class="card-text">{{ $cpu->usage_cpu }}</p>
                    <p class="card-text" id="ID_Server">{{ $cpu->core_cpu }}</p>
                    <p>Data yang akan diperbarui: 
                    <div  id='data-cpu'></div></p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary">more</a>
                </div>
            </div>
        </div>         
        <div class="col-md m-1">
            <div class="card">
                <div class="card-header">{{ $cpu->id }}</div>
                <div class="card-body">
                    <h4 class="card-title">{{ $cpu->id_server }}</h4>
                    <p class="card-text">{{ $cpu->usage_cpu }}</p>
                    <p class="card-text" id="ID_Server">{{ $cpu->core_cpu }}</p>
                    <p>Data yang akan diperbarui: 
                    <div  id='data-ram'></div></p>
                </div>
                <div class="card-footer">
                    <a href="#" class="btn btn-primary">more</a>
                </div>
            </div>
        </div>          
        <div class="col-md m-1">
            <div style="width: 80%; margin: 0 auto;">
                <canvas id="Chart" width="400" height="200"></canvas>
            </div>
        </div>

        <script>
            function getDataAndUpdate() {
                $.ajax({
                    url: '{{ route('home.get', ['id' => $cpu->id_server]) }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        document.getElementById('data-cpu').innerHTML = data.usage_cpu;
                        document.getElementById('data-ram').innerHTML = data.usage_cpu;
                    }, 
                });
            }
        
            // Make the initial request to display the content
            getDataAndUpdate();
        
            // Set an interval to make periodic requests every 5 seconds (adjust the interval as needed)
            setInterval(getDataAndUpdate, 10000);

            // Get chart data from PHP and convert it to JavaScript

            // Create the chart
            var ctx = document.getElementById('Chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["1","2","3","4","5","6","7"],
                    datasets: [{
                        label: 'Data',
                        data: ["1","2","3","4","5","6","7"],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
        
    </div>
</div>
@endsection
