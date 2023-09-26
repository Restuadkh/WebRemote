@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-2">
                <div class="card text-left">
                    <div class="card-body center">
                        <h4 class="card-title">Memory Usage</h4>
                        <div style="width: 100%; margin: 0 auto;">
                            <canvas id="memoryChart" width="auto" height="auto"></canvas>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <div class="input-group date" id="">
                                <input type="text" class="form-control" id="datetimepicker_ram" name="datetimepicker_ram"
                                    placeholder="Select date and time">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card text-left">
                    <div class="card-body center">
                        <h4 class="card-title">CPU Usage</h4>
                        <div style="width: 100%; margin: 0 auto;">
                            <canvas id="Chart" width="auto" height="auto"></canvas>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <div class="input-group date" id="">
                                <input type="text" class="form-control" id="datetimepicker_cpu" name="datetimepicker_cpu"
                                    placeholder="Select date and time">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md mt-2">
                <div class="card text-left">
                    <div class="card-body center">
                        <h4 class="card-title">Temperature</h4>
                        <div style="width: 100%; margin: 0 auto;">
                            <canvas id="tempChart" width="auto" height="auto"></canvas>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <div class="input-group date" id="">
                                <input type="text" class="form-control" id="datetimepicker_temp"
                                    name="datetimepicker_temp" placeholder="Select date and time">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md mt-2">
                <div class="card">
                    <div class="card-header">{{ $cpu->id }}</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $cpu->id_server }}</h4>
                        <p class="card-text">{{ $cpu->usage_cpu }}</p>
                        <p class="card-text" id="ID_Server">{{ $cpu->core_cpu }}</p>
                        <p>Data yang akan diperbarui:
                        <div id='data-ram'></div>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="btn btn-primary">more</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                // Make the initial request to display the content
                getMemoryUpdate();
                gettempChart();
                // getDataAndUpdate();
                getMemoryChart();;
                getDataChart();
                // Set an interval to make periodic requests every 5 seconds (adjust the interval as needed)
                setInterval(getMemoryUpdate, 5000);
                // setInterval(getDataAndUpdate, 5000);
                setInterval(getMemoryChart, 5000);
                setInterval(getDataChart, 5000);
                setInterval(gettempChart, 5000);
                flatpickr("#datetimepicker_ram", {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                });
                flatpickr("#datetimepicker_cpu", {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                });
                flatpickr("#datetimepicker_temp", {
                    enableTime: false,
                    dateFormat: "Y-m-d",
                });
            });

            function byteToMB(byte) {
                return (byte / (1024 * 1024)).toFixed(3);
            }

            function byteToGB(byte) {
                return (byte / (1024 * 1024 * 1024)).toFixed(3);
            }

            function hitungRataRata(dataArray, ukuranKelompok) {
                var hasil = [];

                for (var i = 0; i < dataArray.length; i += ukuranKelompok) {
                    // Mengambil kelompok data dengan panjang ukuranKelompok
                    var kelompok = dataArray.slice(i, i + ukuranKelompok);

                    // Mengkonversi string menjadi angka float dan menjumlahkannya
                    var total = kelompok.reduce((total, nilai) => total + parseFloat(nilai), 0);

                    // Menghitung rata-rata kelompok
                    var rataRata = total / kelompok.length;

                    hasil.push(rataRata);
                }

                return hasil;
            }

            function ubahFormatWaktu(waktuAwal) {
                var date = new Date(waktuAwal);
                var tahun = date.getFullYear();
                var bulan = (date.getMonth() + 1).toString().padStart(2, '0');
                var tanggal = date.getDate().toString().padStart(2, '0');
                var jam = date.getHours().toString().padStart(2, '0');
                var menit = date.getMinutes().toString().padStart(2, '0');
                var detik = date.getSeconds().toString().padStart(2, '0');
                return tahun + '-' + bulan + '-' + tanggal + ' ' + jam + ':' + menit + ':' + detik;
            }

            function hitungRataRataWaktu(dataArray, ukuranKelompok) {
                var hasil = [];

                for (var i = 0; i < dataArray.length; i += ukuranKelompok) {
                    var kelompok = dataArray.slice(i, i + ukuranKelompok);

                    // Mengubah data waktu menjadi timestamp
                    var timestamps = kelompok.map(waktu => new Date(waktu).getTime());

                    var jumlahTimestamp = timestamps.reduce((total, timestamp) => total + timestamp, 0);
                    var rataRataTimestamp = jumlahTimestamp / timestamps.length;

                    // // Mengubah kembali rata-rata timestamp menjadi waktu
                    // var rataRataWaktu = new Date(rataRataTimestamp);

                    // // Mengonversi rata-rata waktu ke zona waktu UTC
                    // rataRataWaktu.setMinutes(rataRataWaktu.getMinutes() - rataRataWaktu.getTimezoneOffset());

                    // // Menggunakan toISOString() untuk menghasilkan format ISO 8601 UTC
                    // var formattedRataRataWaktu = rataRataWaktu.toISOString();

                    hasil.push(rataRataTimestamp);
                }

                return hasil;
            }

            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
            var values = 0;
            var id = 0;
            var datasets = 0;
            var limit = 10000;
            var squent = 10;
            var date = 0;
            var date_ram = 0;
            var date_cpu = 0;
            var date_temp = 0;
            // var id = {{ $cpu->id_server }};
            var RuleValue_ram = document.getElementById('datetimepicker_ram');
            RuleValue_ram.addEventListener('change', function() {
                var selectedValue_ram = RuleValue_ram.value;
                date_ram = selectedValue_ram;
                getMemoryChart();
            });
            var RuleValue_cpu = document.getElementById('datetimepicker_cpu');
            RuleValue_cpu.addEventListener('change', function() {
                var selectedValue_cpu = RuleValue_cpu.value;
                date_cpu = selectedValue_cpu;
                getDataChart();
            });

            var RuleValue_temp = document.getElementById('datetimepicker_temp');
            RuleValue_temp.addEventListener('change', function() {
                var selectedValue_temp = RuleValue_temp.value;
                date_temp = selectedValue_temp;
                gettempChart();
            });
            // function getDataAndUpdate() {
            //     $.ajax({
            //         url: '{{ route('home.get', ['id' => $cpu->id_server]) }}',
            //         type: 'GET',
            //         dataType: 'json',
            //         success: function(data) {
            //             // console.log(data);
            //             document.getElementById('data-cpu').innerHTML = data.usage_cpu; 
            //         }, 
            //     }); 
            // }

            function getMemoryUpdate() {
                $.ajax({
                    url: '{{ route('memory.show', ['id' => $cpu->id_server]) }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: {{ $cpu->id_server }},
                        limit: 1,
                        date: date
                    },
                    success: function(data) {
                        // console.log(data);

                        usage_ram = data.map(data => data.usage_ram);
                        space_ram = data.map(data => data.space_ram);
                        usage_ram_ = byteToMB(usage_ram);
                        space_ram_ = byteToMB(space_ram);
                        // document.getElementById('data-cpu').innerHTML = data.usage_cpu;
                        document.getElementById('data-ram').innerHTML = usage_ram_ + "MB / " + space_ram_ + "MB";
                    },
                });
            }
            // Get chart data from PHP and convert it to JavaScript
            function getDataChart() {
                $.ajax({
                    url: '{{ route('CPU.show', ['id' => $cpu->id_server]) }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: {{ $cpu->id_server }},
                        limit: limit,
                        date: date_cpu
                    },
                    success: function(data) {
                        data = data.reverse();
                        values = data.map(data => data.usage_cpu);
                        created_at = data.map(data => data.created_at);
                        truncatedTexts = created_at.map(text => {
                            if (text.length > 10) {
                                return text.substring(11, 16);
                            }
                            return text;
                        });
                        maxValue = Math.max.apply(null, values);
                        minValue = Math.min.apply(null, values);
                        myChart.options.scales.y.min = minValue - 1;
                        myChart.options.scales.y.max = maxValue + 1;
                        myChart.data.datasets[0].data = values;
                        myChart.data.labels = truncatedTexts;
                        myChart.update();
                        // console.log(created_at); 
                    },
                });
            }

            // function gettempChart() {
            //     $.ajax({
            //         url: '{{ route('temp.show', ['id' => $cpu->id_server]) }}',
            //         type: 'GET', 
            //         dataType: 'json',
            //         data: {
            //             id: {{ $cpu->id_server }},
            //             limit: limit,
            //             date: date_cpu
            //         },
            //         success: function(data) {
            //             data = data.reverse();
            //             values = data.map(data => data.temp);
            //             created_at = data.map(data => data.created_at); 
            //             truncatedTexts = created_at.map(text => {
            //                 if (text.length > 10) {
            //                     return text.substring(11, 16);
            //                 }
            //                 return text;
            //                 }); 
            //             maxValue = Math.max.apply(null, values);
            //             minValue = Math.min.apply(null, values);
            //             myChart.options.scales.y.min = minValue-1;
            //             myChart.options.scales.y.max = maxValue+1;
            //             myChart.data.datasets[0].data = values;
            //             myChart.data.labels = truncatedTexts; 
            //             myChart.update(); 
            //             // console.log(created_at); 
            //         }, 
            //     });  
            // }

            function getMemoryChart() {
                $.ajax({
                    url: '{{ route('memory.show', ['id' => $cpu->id_server]) }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: {{ $cpu->id_server }},
                        limit: limit,
                        date: date_ram
                    },
                    success: function(data_memory) {
                        data_memory = data_memory.reverse();
                        usage_ram_memory = data_memory.map(data_memory => data_memory.usage_ram);
                        space_ram_memory = data_memory.map(data_memory => data_memory.space_ram);
                        usage_swap_memory = data_memory.map(data_memory => data_memory.usage_swap);
                        created_at_memory = data_memory.map(data_memory => data_memory.created_at);
                        truncatedTexts_memory = created_at_memory.map(text_memory => {
                            if (text_memory.length > 10) {
                                return text_memory.substring(11, 16);
                            }
                            return text_memory;
                        });
                        usage_ram_memory = usage_ram_memory.map(byteToMB);
                        usage_swap_memory = usage_swap_memory.map(byteToMB);

                        maxValue_ram = Math.max.apply(null, usage_ram_memory);
                        maxValue_swap = Math.max.apply(null, usage_swap_memory);
                        minValue_ram = Math.min.apply(null, usage_ram_memory);
                        minValue_swap = Math.min.apply(null, usage_swap_memory);

                        if (maxValue_ram >= maxValue_swap) {
                            maxValue = maxValue_ram;
                        } else {
                            maxValue = maxValue_swap;
                        }
                        if (minValue_ram <= minValue_swap) {
                            minValue = minValue_ram;
                        } else {
                            minValue = minValue_swap;
                        }
                        memoryChart.options.scales.y.min = minValue - 1;
                        memoryChart.options.scales.y.max = maxValue + 1;
                        memoryChart.data.datasets[0].data = usage_ram_memory;
                        memoryChart.data.datasets[1].data = usage_swap_memory;
                        memoryChart.data.labels = truncatedTexts_memory;
                        memoryChart.update();
                        // console.log(created_at_memory);  
                    },
                });
            }

            function gettempChart() {
                $.ajax({
                    url: '{{ route('temp.show', ['id' => $cpu->id_server]) }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: {{ $cpu->id_server }},
                        limit: limit,
                        date: date_temp
                    },
                    success: function(data_temp) {
                        data_temp = data_temp.reverse();
                        created_at_temp = data_temp.map(data_temp => data_temp.created_at);
                        temp = data_temp.map(data_temp => data_temp.temp);
                        truncatedTexts_temp = created_at_temp.map(text_temp => {
                            if (text_temp.length > 10) {
                                return text_temp.substring(11, 16);
                            }
                            return text_temp;
                        });

                        maxValue = Math.max.apply(null, temp);
                        minValue = Math.min.apply(null, temp);

                        tempChart.options.scales.y.min = minValue - 1;
                        tempChart.options.scales.y.max = maxValue + 1;
                        tempChart.data.datasets[0].data = temp;
                        tempChart.data.labels = truncatedTexts_temp;
                        tempChart.update();
                        console.log(created_at_temp);
                        // console.log(truncatedTexts_temp);
                    },
                });
                console.log(date_temp);

            }
            // Create the chart
            var ctx = document.getElementById('Chart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: id,
                    datasets: [{
                        label: "CPU Usage",
                        data: values,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        borderWidth: 1.5,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0.5,
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

            var ctx_memory = document.getElementById('memoryChart').getContext('2d');
            var memoryChart = new Chart(ctx_memory, {
                type: 'line',
                data: {
                    labels: id,
                    datasets: [{
                        label: "Memory Usage",
                        data: values,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        borderWidth: 1.5,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0.5,
                    }, {
                        label: "Swap Usage",
                        data: values,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        borderWidth: 1.5,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0.5,
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

            var ctx_temp = document.getElementById('tempChart').getContext('2d');
            var tempChart = new Chart(ctx_temp, {
                type: 'line',
                data: {
                    labels: id,
                    datasets: [{
                        label: "Temperature",
                        data: values,
                        backgroundColor: getRandomColor(),
                        borderColor: getRandomColor(),
                        borderWidth: 1.5,
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0.5,
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
                        text: 'Temperature Log CPU'
                    },
                    interaction: {
                        intersect: false,
                    }
                }
            });
        </script>

    </div>
@endsection
