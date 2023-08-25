@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-3 m-1">
                <div class="card">
                    <div class="card-header"> </div>
                    <div class="card-body">
                        <h4 class="card-title"> </h4>
                        <p class="card-text"> </p>
                        <p class="card-text" id="ID_Server"> </p>
                        <div id="halfCircleChart" style="width: 100%; height: 200px;"></div>
                        <div id='data-container'></div>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href=" " class="btn btn-primary">more</a>
                    </div>
                </div>
            </div>
            <div class="col-6 m-1">
                <div class="card">
                    <div class="card-header"> </div>
                    <div class="card-body">
                        <h4 class="card-title"> </h4>
                        <p class="card-text"> </p>
                        <p class="card-text" id="ID_Server"> </p>
                        <canvas id="Chart" width="800" height="300"></canvas>
                        <div id='data-container'></div>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href=" " class="btn btn-primary">more</a>
                    </div>
                </div>
            </div>
        </div>
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
                            <div id='data-container'></div>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('home.show', ['id' => $data_server->id]) }}" class="btn btn-primary">more</a>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
        <script>
            function getRandomData(min, max) {
                return Math.random() * (max - min) + min;
            }

            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
            updatedatabese();
            setInterval(updatedatabese, 5000);

            var trafic = 0;
            var chart = Highcharts.chart('halfCircleChart', {
                chart: {
                    type: 'pie',
                    backgroundColor: 'transparent', // Hapus latar belakang
                },
                title: {
                    text: null, // Hapus judul
                },
                plotOptions: {
                    pie: {
                        startAngle: -90, // Mulai dari atas
                        endAngle: 90, // Berakhir di bawah
                        center: ['50%', '75%'], // Pusat chart
                        dataLabels: {
                            enabled: false, // Tidak menampilkan label pada setengah lingkaran
                        },
                    },
                },
                series: [{
                    name: 'Setengah Lingkaran',
                    innerSize: '50%', // Ukuran lingkaran dalam
                    data: [{
                            name: 'Filled',
                            y: 10,
                            color: 'rgba(75, 192, 192, 0.2)'
                        },
                        {
                            name: 'Empty',
                            y: 10,
                            color: 'transparent'
                        },
                    ],
                    animation: true // Enable animation
                }, ],
            });

            function updatedatabese() {
                $.ajax({
                    url: '{{ route('db.show', ['id' => 4]) }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        data = data.reverse();
                        trafic = data.map(data => data.trafic);
                        created_at = data.map(data => data.created_at); 
                        truncatedTexts = created_at.map(text => {
                            if (text.length > 10) {
                                return text.substring(11, 19);
                            }
                            return text;
                            });

                        maxValue = Math.max.apply(null, trafic);
                        minValue = Math.min.apply(null, trafic);
                        myChart.options.scales.y.min = minValue - 1;
                        myChart.options.scales.y.max = maxValue + 1;
                        myChart.data.datasets[0].data = trafic;
                        myChart.data.labels = truncatedTexts;
                        myChart.update(); 

                        // trafic = getRandomData(40, 100);
                        console.log(trafic);
                        chart.series[0].update({
                            data: [
                                ['Filled', trafic[0]],
                                ['Empty', 0],
                            ],
                            animation: true // Enable animation
                        });
                    }
                });
            }

            var ctx = document.getElementById('Chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [1,2,3],
                    datasets: [{
                        label: "Usage CPU",
                        data: trafic,
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
