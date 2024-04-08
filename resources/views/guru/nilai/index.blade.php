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
                                Tugas : {{ $data->title }}
                            </div>
                            <div class="col text-end ">
                                Deadline : {{ $data->tanggal }} - {{ $data->waktu }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">{{ $data->title }}</h5>
                                <p class="card-text">Materi dan Soal ini tentang {{ $data->deskripsi }}</p>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col border-top p-1">
                                <h3 class="text-center">Penilaian</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Nim/Nind</th>
                                            <th scope="col">Tanggal kumpulkan</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Penilaian</th>
                                        </tr>
                                    </thead>

                                    <tbody id="user">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($penilaian as $item)
                                            <tr>
                                                <td>{{ $i }}</td>
                                                <td><img src="{{ asset('image/users/' . $item->foto) }}" width="75"
                                                        height="75" class="img-circle">
                                                </td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->nim }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                @if ($item->status == 'Terlambat')
                                                    <td class="text-danger">{{ $item->status }}</td>
                                                @else
                                                    <td class="text-success">{{ $item->status }}</td>
                                                @endif
                                                <td>
                                                    @if ($item->cekNilai)
                                                        <button type="button" class="btn btn-success" disabled>
                                                            Nilai : {{$item->cekNilai}}
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-toggle="modal"
                                                            data-target="#editUserModal{{ $item->id_send }}">
                                                            Beri Penilaian
                                                        </button>
                                                    @endif


                                                </td>
                                            </tr>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination">
                                {{ $penilaian->onEachSide(5)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        @foreach ($penilaian as $item)
            <div class="modal fade" id="editUserModal{{ $item->id_send }}" tabindex="-1" role="dialog"
                aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Beri Nilai</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('penilaian.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_send" value="{{ $item->id_send }}">
                            <div class="modal-body">
                                <div class="form-group">
                                    <iframe src="{{ asset('image/tugas/' . $item->file) }}"
                                        style="width:100%; height:500px;"></iframe>
                                </div>
                                <div class="form-group">
                                    <label for="nilai">Penilaian</label>
                                    <input type="number" name="nilai" id="nilai" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="komentar">Komentar (optional)</label>
                                    <textarea name="komentar" id="komentar" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Penilaian</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach










    @endsection
