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
                <canvas id="Chart" width="800" height="800"></canvas>
            </div>
            <div  id='data-chart'></div></p>
        </div>     

        <script>
            function getDataAndUpdate() {
                $.ajax({
                    url: '{{ route('home.get', ['id' => $cpu->id_server]) }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        document.getElementById('data-cpu').innerHTML = data.usage_cpu;
                        document.getElementById('data-ram').innerHTML = data.usage_cpu;
                    }, 
                });
            }
            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
            // Make the initial request to display the content
            getDataAndUpdate();
        
            // Set an interval to make periodic requests every 5 seconds (adjust the interval as needed)
            setInterval(getDataAndUpdate, 10000);
            setInterval(getDataChart, 10000);

            var values = 0;
            var id = 0;
            var datasets = 0;
            // Get chart data from PHP and convert it to JavaScript
            function getDataChart() {

                var cores = {{ $cpu->core_cpu }};
                console.log(cores); 
                for(var a=0; a<cores; a++){
                console.log(a); 
                    $.ajax({
                        url: '{{ route('CPU.show', ['id' => $cpu->id_server, 'core' => 'all' ])}}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            id = data.map(data => data.id);
                            // values = data.map(data => data.usage_cpu);
                            core = data.map(data => data.core_cpu);
                            // document.getElementById('data-chart').innerHTML = core; 
                            // myChart.data.datasets[0].data = values;                        
                            // myChart.data.labels = id;
                            // myChart.data.datasets[1].data = core;
                            // myChart.data.labels = id;
                            // myChart.update();
                            datasets[a] = {
                                label: "Usage CPU",
                                data: values,
                                backgroundColor: getRandomColor(),
                                borderColor: getRandomColor(),
                                borderWidth: 1.5,
                                fill: false,
                                tension: 0.4
                            };
                        }, 
                    }); 
                }
            }
            
            getDataChart();
            // Create the chart
            var ctx = document.getElementById('Chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: id,
                    datasets: datasets
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
