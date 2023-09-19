@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-3 mt-2">
                <div class="card border-0">
                    <div class="card-header">Query Proses</div>
                    <div class="card-body">
                        <h5 class="card-title"> </h5>
                        <p class="card-text"> </p>
                        <p class="card-text" id="ID_Server"> </p>
                        <canvas id="doughnutChart" width="100" height="100"></canvas>
                        </p>

                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                            Mulai Proses
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-9 mt-2">
                <div class="card border-0">
                    <div class="card-header">Query Proses List</div>
                    <div class="card-body">
                        <h6 class="card-title"> </h6>
                        <p class="card-text"> </p>
                        <p class="card-text" id="ID_Server"> </p>
                        <canvas id="Chart" width="800" height="370"></canvas>
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <div class="input-group date" id="">
                                <input type="text" class="form-control" id="datetimepicker" name="datetimepicker"
                                    placeholder="Select date and time">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md mt-2">
                <div class="card border-0">
                    <div class="card-header">Proses List</div>
                    <div class="card-body">
                        <table class="table table-striped table-inverse table-responsive">
                            <thead class="">
                                <tr>
                                    <th>Database</th>
                                    <th>Proseslist</th>
                                    <th>Count</th>
                                </tr>
                                </thead>
                                <tbody class="profress"> 
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            @foreach ($server as $data_server)
                <div class="col-md-6 mt-2">
                    <div class="card border-0">
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
    </div>
    <script>
        $(document).ready(function() {
            updatetest();
            updateproseslist(4);
            updatedatabese(4, 0);
            updatedatabese(2, 1);
            setInterval(updatetest, 5000);
            setInterval(function() {
                updatedatabese(4, 0);
            }, 5000);
            setInterval(function() {
                updatedatabese(2, 1);
            }, 5000);
            setInterval(function() {
                updateproseslist(4);
            }, 5000);
            // Initialize Flatpickr
            flatpickr("#datetimepicker", {
                enableTime: false,
                dateFormat: "Y-m-d",
            });


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

                // Mengonversi rata-rata waktu ke zona waktu UTC
                rataRataWaktu.setMinutes(rataRataWaktu.getMinutes() - rataRataWaktu.getTimezoneOffset());

                // Menggunakan toISOString() untuk menghasilkan format ISO 8601 UTC
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
        var hourLabels = Array.from({
            length: 30
        }, (_, index) => `${index}`);

        var trafic = 0;
        var limit = 10000;
        var datalimit = 5;
        var squent = 20;
        var date = 0;

        var RuleValue = document.getElementById('datetimepicker');
        RuleValue.addEventListener('change', function() {
            var selectedValue = RuleValue.value;
            date = selectedValue;
            updatedatabese(4, 0);
            updatedatabese(2, 1);
        });

        function updatetest() {
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
                    // trafic_ = response.map(response => response.trafic);
                    // data = hitungRataRata(trafic_,squent);
                    // console.log(data);
                }
            });
        }


        function updateproseslist(id_server) {
            $.ajax({
                type: 'GET',
                url: '{{ route('db.getproseslist') }}',
                contentType: 'application/json',
                data: {
                    id_server: id_server,
                },
                success: function(response) {
                    $('.progress_').remove();

                    console.log(response);
                    response.forEach(function(item) {
                        var progress = $(
                            '<tr class="progress_"><td>'+ item.db +'</td>');
                        var progressBar = $('<td><div class="progress_ progress mt-2 bg-info" role="progressbar" aria-label="Info example" aria-valuenow="' +
                            item.count + '" aria-valuemin="0" aria-valuemax="50"><div class="progress-bar bg-success" style="width: ' + item.count +
                            '%"></div></div></td><td>' + item.count + '</td></tr>'); 
                        progress.append(progressBar); 
                        $('.profress').append(progress); 
                    });
                }
            });
        }
        function updatedatabese(id_server, Datachart) {
            $.ajax({
                url: '{{ route('db.show') }}',
                type: 'GET',
                contentType: 'application/json',
                data: {
                    id: id_server,
                    limit: limit,
                    date: date
                },
                success: function(data) {
                    // console.log(data);
                    data = data.reverse();
                    trafic = data.map(data => data.trafic);
                    created_at = data.map(data => data.created_at);
                    Text = hitungRataRataWaktu(created_at, squent);
                    // console.log(created_at);
                    truncatedTexts = Text.map(text => {
                        if (text.length > 10) {
                            return text.substring(11, 16);
                        }
                        return text;
                    });
                    created_at_ = truncatedTexts.map(truncatedTexts => truncatedTexts.created_at);
                    // console.log(Text);

                    maxValue = Math.max.apply(null, trafic);
                    minValue = Math.min.apply(null, trafic);
                    trafic_ = hitungRataRata(trafic, squent);
                    if (myChart.options.scales.y.min > minValue) {
                        myChart.options.scales.y.min = minValue - 1;
                    }
                    if (myChart.options.scales.y.max < maxValue) {
                        myChart.options.scales.y.max = maxValue + 1;
                    }
                    myChart.data.datasets[Datachart].data = trafic_;
                    myChart.data.labels = truncatedTexts;
                    myChart.update();
                    doughnutChart.data.datasets[0].data[Datachart] = trafic[0];
                    doughnutChart.data.datasets[0].label[Datachart] = created_at[0];
                    doughnutChart.update();
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
                    }
                ]
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
                options: {
                    responsive: true,
                    maintainAspectRatio: false // Allow chart height to adjust
                },
            },
        });
        var ctxs = document.getElementById('doughnutChart').getContext('2d');
        var doughnutChart = new Chart(ctxs, {
            type: 'doughnut',
            data: {
                labels: ['Server 10', 'Server 11'],
                datasets: [{
                    label: "Query Proses",
                    data: [50, 50], // Data proporsi masing-masing bagian
                    backgroundColor: [getRandomColor(), getRandomColor()],
                }, ],
                options: {
                    animation: {
                        onComplete: function(animation) {
                            var centerX = this.chart.chartArea.left + (this.chart.chartArea.right - this.chart
                                .chartArea.left) / 2;
                            var centerY = this.chart.chartArea.top + (this.chart.chartArea.bottom - this.chart
                                .chartArea.top) / 2;

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
