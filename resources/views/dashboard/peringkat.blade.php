@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h1>Peringkat Mata Kuliah {{$pelajaran}}</h1>
        </div>
        <!-- Tabel Responsif -->
        @if (session()->has('success'))
            @include('component.alert', [
                'message' => session('success'),
                'status' => 'success',
            ])
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <form action="{{ route('dashboard.peringkat') }}" method="get">
                                    <div class="input-group">
                                        <select class="custom-select" name="select">
                                            <option value="">Pilih Matkul</option>
                                            @foreach ($select as $item)
                                                <option value="{{ $item->nama_pelajaran }}">{{ $item->nama_pelajaran }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">Button</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Peringkat nilai 10 teratas</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <canvas id="myChart" class="text-center"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if ($nilai)
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($nilai as $data)
                            '{{ $data->name }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Nilai',
                        data: [
                            @foreach ($nilai as $data)
                                '{{ $data->nilai }}',
                            @endforeach
                        ],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
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
    @endif












@endsection
