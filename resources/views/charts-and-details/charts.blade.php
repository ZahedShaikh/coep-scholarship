@extends('admin.layout.appToSearch')
@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.css" integrity="sha256-aa0xaJgmK/X74WM224KMQeNQC2xYKwlAt08oZqjeF0E=" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" >Colleges VS Students receiving benefits</div>
                <br>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="from">From</label>
                        <select id="from" name="category" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="to">To</label>
                        <select id="to" name="category" class="form-control">
                        </select>
                    </div>
                </div>
                <br>

                <canvas id="canvas" width="700" height="200"></canvas>
            </div>
        </div>

        <!--        <div class="col-md-5">
                    <div class="card">
                        <div class="card-header" >{{ ucfirst(config('auth.prefix')) }}</div>
                        <br>
        
                        <canvas id="canvas" width="50" height="50"></canvas>
        
                    </div>
                </div>-->

    </div>

</div>


<script>

    $(document).ready(function () {

        //  Dynamic selection of college
        $("#select-college, #select-category").change(function () {
            var selectedCollege = $("#select-college").val();
            var selectedCategory = $("#select-category").val();
            functionCollege(selectedCollege, selectedCategory);
        });

        var currentYear = (new Date).getFullYear();
        var option = '';
        for (var i = 2015; i <= currentYear; i++) {
            option += '<option value="' + i + '">' + i + '</option>';
        }
        $('#from').append(option);
        $('#to').append(option);
        $("#from").val(currentYear - 1);
        $("#to").val(currentYear);
        // Call for defualt current and erlier year
        fetch_customer_data(currentYear - 1, currentYear);

        // Call for givan year
        function fetch_customer_data(from, to)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{ route('updateCharts') }}",
                method: "GET",
                contentType: "application/json; charset=utf-8",
                data: {from: from, to: to},
                dataType: "json",
                success: function (data)
                {
                    console.log("GOOD: " + data);
                    functionChart(data);
                },
                error: function (data) {
                    console.log(data.status + " " + data.statusText);
                }
            });
        }


        $('#from, #to').change(function () {
            var from = $('#from').val();
            var to = $('#to').val();
            //console.log(from + " " + to);
            if (from > to) {
                alert('Enter correct year');
                $('#to').val(from);
            } else {
                fetch_customer_data(from, to);
            }
        });

//        (function ($) {
//            $.fn.assign = function (msg) {
//                assignScholarshipFunction(msg);
//            };
//        })(jQuery);

    });

    function functionChart(data1) {
        console.log("----------------------" + data1['College'] + "----------------------------------");

        var chartdata = {
            type: 'bar',
            data: {
                labels: data1['College'],
                // labels: month,
                datasets: [
                    {
                        label: 'FY',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: [10, 20, 30, 50]
                    },
                    {
                        label: 'SY',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        data: [10, 20, 30, 50]
                    }, {
                        label: 'TY',
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1,
                        data: [10, 20, 30, 50]
                    }, {
                        label: 'BE',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
//                    barPercentage: 0.5,
//                    barThickness: 40,
//                    maxBarThickness: 8,
//                    minBarLength: 2,
//                    data: [10, 20, 30, 40, 50, 60, 70],
                        borderWidth: 1,
                        data: [10, 20, 30, 50]
                    }
                ]
            },

            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                    display: true
                },
                "hover": {
                    "animationDuration": 0
                },
                "animation": {
                    "duration": 1,
                    "onComplete": function () {
                        var chartInstance = this.chart,
                                ctx = chartInstance.ctx;

                        ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'bottom';

                        this.data.datasets.forEach(function (dataset, i) {
                            var meta = chartInstance.controller.getDatasetMeta(i);
                            meta.data.forEach(function (bar, index) {
                                var data = dataset.data[index];
                                ctx.fillText(data, bar._model.x, bar._model.y - 5);
                            });
                        });
                    }
                },
                title: {
                    display: false,
                    text: ''
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                //max: 20
                            }, gridLines: {
                                color: "rgba(0, 0, 0, 0)"
                            }
                        }
                    ], xAxes: [{
                            gridLines: {
                                color: "rgba(1, 1, 1, 1)"
                            }
                        }]
                }
            }
        };
        console.log(chartdata);

        var ctx = document.getElementById('canvas').getContext('2d');
        new Chart(ctx, chartdata);

    }

</script>

@endsection
