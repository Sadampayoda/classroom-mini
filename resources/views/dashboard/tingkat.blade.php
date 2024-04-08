@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h1>Progress {{ auth()->user()->name }}</h1>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div id="chart">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.highcharts.com/highcharts.js"></script> 
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script>
        var data = {!! json_encode($tugas) !!}


        var categories = [];
        var seriesData = [];

        data.forEach(function(item) {
            categories.push(item.nama_pelajaran);
            seriesData.push(item.jumlah_tugas);
        });

        // Render chart
        Highcharts.chart('chart', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Jumlah Tugas per Mata Pelajaran'
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Jumlah Tugas'
                }
            },
            legend: {
                reversed: true
            },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Jumlah Tugas',
                data: seriesData
            }]
        });
    </script>
@endsection
