@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md m-1">
            <div class="card text-left">
              <img class="card-img-top" src="holder.js/100px180/" alt="">
              <div class="card-body center">
                <h4 class="card-title">Title</h4> 
                <div style="width: 100%; margin: 0 auto;">
                    <canvas id="Chart" width="800" height="400"></canvas>
                </div> 
              </div>
            </div>
        </div>  
    </div>   
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
                $.ajax({
                    url: '{{ route('CPU.show', ['id' => $cpu->id_server])}}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        id = data.map(data => data.id);
                        values = data.map(data => data.usage_cpu);
                        core = data.map(data => data.core_cpu);
                        created_at = data.map(data => data.created_at); 
                        truncatedTexts = created_at.map(text => {
                            if (text.length > 10) {
                                return text.substring(0, 10);
                            }
                            return text;
                            });
                        maxValue = Math.max.apply(null, values);
                        minValue = Math.min.apply(null, values);
                        myChart.options.scales.y.min = minValue-1;
                        myChart.options.scales.y.max = maxValue+1;

                        myChart.data.datasets[0].data = values;
                        myChart.data.labels = truncatedTexts;
                        
                        myChart.update(); 
                        console.log(data); 
                    }, 
                });  
            }
            
            getDataChart();
            // Create the chart
            var ctx = document.getElementById('Chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: id,
                    datasets: [{
                                label: "Usage CPU",
                                data: values,
                                backgroundColor: getRandomColor(),
                                borderColor: getRandomColor(),
                                borderWidth: 1.5,
                                fill: false,
                                tension: 0.4
                            }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }, 
                    title: {
                        display: true,
                        text: 'Server Log CPU'
                    },
                    interaction: {
                        intersect: false,
                    }
                }
            });

        </script>
        
</div>
@endsection
