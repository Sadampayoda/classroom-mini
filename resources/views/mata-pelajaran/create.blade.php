@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h1>Tugas {{ $data->title }}</h1>
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
                <div class="card m-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-start">
                                @if ($status)
                                    @if ($status == 'Terlambat')
                                        Status : <span class=" text-danger">{{ $status }}</span>
                                    @else
                                        Status : <span class=" text-success">{{ $status }}</span>
                                    @endif
                                @else
                                    Status : <span class="text-muted">Belum kumpulkan</span>
                                @endif
                            </div>
                            <div class="col text-end ">
                                Deadline : {{ $data->tanggal }} - {{ $data->waktu }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">{{ $data->title }}</h5>
                                <p class="card-text">Mata Kuliah ini adalah {{ $data->deskripsi }}</p>
                                @if ($item)
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#fileModal">Lihat
                                        File</button>
                                @else
                                    <button class="btn btn-primary" disabled>Belum Kumpulan</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card m-3">
                    <div class="card-body">
                        <div class="row mb-2">
                            @if ($nilai)
                                <div class="col text-start">
                                    <p class="text-muted">Nilai : <span class="text-success">{{ $nilai->nilai }}</span></p>
                                </div>
                            @else
                                <div class="col text-start">
                                    Nilai :
                                </div>
                                <div class="col text-end text-danger">
                                    Belum Dinilai
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col">
                                @if ($nilai)
                                    <input type="text" name="file" disabled class="form-control"
                                        value="Tugas Sudah dikumpulkan">
                                    <div class="d-grid">
                                        <button type="submit" name="id_tugas" disabled value="{{ $data->id }}"
                                            class="btn btn-dark">Sudah dinilai</button>
                                    </div>
                                @else
                                    @if ($item)
                                        <form action="{{ route('send-tugas.destroy', ['send_tuga' => $item->id_send]) }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('DELETE')
                                            <input type="text" name="file" disabled class="form-control"
                                                value="Tugas Sudah dikumpulkan">
                                            <div class="d-grid">
                                                <button type="submit" name="id_tugas" value="{{ $data->id }}"
                                                    class="btn btn-dark">Batal Send Tugas</button>
                                            </div>
                                        </form>
                                    @else
                                        <form action="{{ route('send-tugas.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" class="form-control">
                                            <div class="d-grid">
                                                <button type="submit" name="id_tugas" value="{{ $data->id }}"
                                                    class="btn btn-dark">Send Tugas</button>
                                                    <p class="text-center text-muted"><span>File Wajib format pdf</span></p>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-3">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col text-center">
                                Komentar dari Dosen
                            </div>
                        </div>
                        <div class="row">
                            @if ($nilai)
                                <div class="col ">
                                    <textarea class="form-control" name="komentar"cols="40" rows="5" disabled>{{ $nilai->komentar }}</textarea>
                                </div>
                            @else
                                <div class="col ">
                                    <textarea class="form-control" name="komentar"cols="40" rows="5" disabled>Belum ada Komentar</textarea>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>



        @if ($item)
            <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tampilkan File</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <iframe src="{{ asset('image/tugas/' . $item->file) }}"
                                style="width:100%; height:500px;"></iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    










    @endsection
