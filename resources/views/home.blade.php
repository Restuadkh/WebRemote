@extends('layouts.app')

@section('content')
    <div class="container"> 
        <div class="row justify-content-center">
            <div class="col-md-3 m-1">
                <div class="card">
                    <div class="card-header">Query Proses</div>
                    <div class="card-body">
                        <h5 class="card-title"> </h5>
                        <p class="card-text"> </p>
                        <p class="card-text" id="ID_Server"> </p>
                        <canvas id="doughnutChart" width="200" height="200"></canvas>
                        <div id="centerText10" style=""></div>
                        <div id=""">/</div>
                        <div id="centerText11" style="position: absolute; top: 55%; left: 42%; transform: translate(-50%, -50%); font-size: 12px;"></div>
                        <div id='data-container'></div>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href=" " class="btn btn-primary">more</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 m-1">
                <div class="card">
                    <div class="card-header">Query Proses List</div>
                    <div class="card-body">
                        <h6 class="card-title"> </h6>
                        <p class="card-text"> </p>
                        <p class="card-text" id="ID_Server"> </p>
                        <canvas id="Chart" width="800" height="400"></canvas>
                        <div id='data-container'></div>
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                          <select class="form-control" name="RuleValue" id="RuleValue">
                            <option value="10">10</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                            <option value="1000">1000</option>
                            <option value="10000">10000</option>
                          </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($server as $data_server)
                <div class="col-md-3 m-1">
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
            $(document).ready(function() {
            updatetest();
            updatedatabese10();
            updatedatabese11();
            updatedoughnut10();
            updatedoughnut11();
            setInterval(updatetest, 5000); 
            setInterval(updatedatabese10, 5000); 
            setInterval(updatedatabese11, 5000); 
            setInterval(updatedoughnut10, 5000); 
            setInterval(updatedoughnut11, 5000);
            });
            function hitungRataRata(dataArray, ukuranKelompok) {
                var hasil = [];
                
                for (var i = 0; i < dataArray.length; i += ukuranKelompok) {
                    var kelompok = dataArray.slice(i, i + ukuranKelompok);
                    var jumlah = kelompok.reduce((total, nilai) => total + nilai, 0);
                    var rataRata = jumlah / kelompok.length;
                    hasil.push(rataRata);
                }
                
                return hasil;
            }
            function hitungRataRataWaktu(dataArray, ukuranKelompok) {
                var hasil = [];
                
                for (var i = 0; i < dataArray.length; i += ukuranKelompok) {
                    var kelompok = dataArray.slice(i, i + ukuranKelompok);
                    
                    // Mengubah data waktu menjadi timestamp
                    var timestamps = kelompok.map(waktu => new Date(waktu).getTime());
                    
                    var jumlahTimestamp = timestamps.reduce((total, timestamp) => total + timestamp, 0);
                    var rataRataTimestamp = jumlahTimestamp / timestamps.length;
                    
                    // Mengubah kembali rata-rata timestamp menjadi waktu
                    var rataRataWaktu = new Date(rataRataTimestamp);

                    var formattedRataRataWaktu = rataRataWaktu.toISOString();
                    
                    hasil.push(formattedRataRataWaktu);
                }
                
                return hasil;
            }

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
            var hourLabels = Array.from({ length: 30 }, (_, index) => `${index}`);

            var trafic = 0;
            var limit = 10;
            var datalimit = 10;
            var squent = 20;
            var RuleValue = document.getElementById('RuleValue');
            RuleValue.addEventListener('change', function () {
                var selectedValue = RuleValue.value; 
                // console.log(selectedValue);
                datalimit = selectedValue;
                limit = selectedValue; 
                updatetest()
                updatedatabese10();                
                updatedatabese11();
                // Update the chart data and re-render
                // myChart.data.datasets[0].data = newData;
                // myChart.update();
            }); 

            function updatetest(){
                $.ajax({
                    type: 'GET',
                    url: '{{ route('db.show') }}',
                    contentType: 'application/json',
                    data: {
                        id: '4',
                        limit: datalimit
                    },
                    success: function(response) {
                        // console.log(response);
                        trafic_ = response.map(response => response.trafic);
                        data = hitungRataRata(trafic_,squent);
                        console.log(data);
                    }
                });
            }

            function updatedatabese10() {
                $.ajax({
                    url: '{{ route('db.show') }}',
                    type: 'GET',
                    contentType: 'application/json',
                    data: {
                        id: '4',
                        limit: limit
                    },
                    success: function(data) {
                        // console.log(data);
                        data = data.reverse();
                        trafic = data.map(data => data.trafic);
                        created_at = data.map(data => data.created_at);  
                        Text = hitungRataRataWaktu(created_at,squent);
                        truncatedTexts = Text.map(text => {
                            if (text.length > 10) {
                                return text.substring(11, 16);
                            }
                            return text;
                            }); 
                        maxValue = Math.max.apply(null, trafic);
                        minValue = Math.min.apply(null, trafic);
                        trafic_ = hitungRataRata(trafic,squent);
                        if(myChart.options.scales.y.min > minValue ){ 
                            myChart.options.scales.y.min = minValue - 1;
                        } 
                        if(myChart.options.scales.y.max < maxValue){
                            myChart.options.scales.y.max = maxValue + 1;
                        }
                        // myChart.options.scales.y.min = minValue - 1;
                        // myChart.options.scales.y.max = maxValue + 1;
                        myChart.data.datasets[1].data = trafic_;
                        // myChart.data.datasets[1].label = truncatedTexts;

                        myChart.data.labels = truncatedTexts; 
                        myChart.update();  
                    }
                });
            }
            function updatedatabese11() {
                $.ajax({
                    url: '{{ route('db.show') }}',
                    type: 'GET',
                    contentType: 'application/json',
                    data: {
                        id: '2',
                        limit: limit
                    },
                    success: function(data) {
                        // console.log(data);
                        data = data.reverse();
                        trafic = data.map(data => data.trafic);
                        created_at = data.map(data => data.created_at);  
                        Text = hitungRataRataWaktu(created_at,squent); 
                        // console.log(Text);
                        
                        truncatedTexts = Text.map(text => {
                            if (text.length > 10) {
                                return text.substring(11, 16);
                            }
                            return text;
                            }); 
                        maxValue = Math.max.apply(null, trafic);
                        minValue = Math.min.apply(null, trafic);
                        trafic_ = hitungRataRata(trafic,squent);

                        if(myChart.options.scales.y.min > minValue ){ 
                            myChart.options.scales.y.min = minValue - 1;
                        } 
                        if(myChart.options.scales.y.max < maxValue){
                            myChart.options.scales.y.max = maxValue + 1;
                        }
                        // myChart.options.scales.y.min = minValue - 1;
                        // myChart.options.scales.y.max = maxValue + 1;
                        myChart.data.datasets[0].data = trafic_;
                        // myChart.data.datasets[1].label = truncatedTexts;
                        myChart.data.labels = truncatedTexts;
                        myChart.update();  
                    }
                });
            }
            function updatedoughnut10() {
                $.ajax({
                    url: '{{ route('dbs.get', ['id' => 4]) }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        data = data.reverse();
                        trafic = data.map(data => data.trafic);
                        created_at = data.map(data => data.created_at);
                        // console.log(trafic);
                        
                        doughnutChart.data.datasets[0].data[0] = trafic; 
                        doughnutChart.data.datasets[0].label[0] = created_at; 
                        doughnutChart.update();
                        document.getElementById('centerText10').innerHTML = trafic;
                    }
                });
            }
            function updatedoughnut11() {
                $.ajax({
                    url: '{{ route('dbs.get', ['id' => 2]) }}',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        data = data.reverse();
                        trafic = data.map(data => data.trafic);
                        created_at = data.map(data => data.created_at);
                        // console.log(trafic);
                        doughnutChart.data.datasets[0].data[1] = trafic;
                        doughnutChart.data.datasets[0].label[1] = created_at;
                        doughnutChart.update();  
                        document.getElementById('centerText11').innerHTML = trafic;
                    }
                });
            }

            var ctx = document.getElementById('Chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: hourLabels,
                    datasets: [{
                        label: "Server 10",
                        data: trafic,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        borderWidth: 1.5,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0.5,
                    },
                    {
                        label: "Server 11",
                        data: trafic,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        borderWidth: 1.5,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0.5,
                    }]
                },
                options: {
                    animation: {
                        duration: 1000, // Animation duration in milliseconds
                        easing: "easeOutQuad", // Easing function for animation
                    },
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
                    },
                },
            });
            var ctxs = document.getElementById('doughnutChart').getContext('2d');
            var doughnutChart = new Chart(ctxs, {
                type: 'doughnut',
                data: {
                    labels: ['Server 10','Server 11'],
                    datasets: [
                        {
                            label: "Query Proses",
                            data: [50 , 50], // Data proporsi masing-masing bagian
                            backgroundColor: [getRandomColor(), getRandomColor()],
                        },
                    ],
                    options: {
                        animation: {
                            onComplete: function(animation) {
                                var centerX = this.chart.chartArea.left + (this.chart.chartArea.right - this.chart.chartArea.left) / 2;
                                var centerY = this.chart.chartArea.top + (this.chart.chartArea.bottom - this.chart.chartArea.top) / 2;

                                var ctx = this.chart.ctx;
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                ctx.font = '20px Arial';
                                ctx.fillStyle = 'black';
                                ctx.fillText('Center Text', centerX, centerY);
                            }
                        }
                    },
                },
            });
        </script>
    </div>
@endsection
