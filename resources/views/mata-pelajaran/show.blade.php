@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h1>Tugas {{ $pelajaran->nama_pelajaran }}</h1>
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
            <div class="col-6 mb-2">
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#createUserModal">
                    Tambah Tugas {{ $pelajaran->nama_pelajaran }}
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @foreach ($data as $item)
                    <div class="card m-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                    <p class="card-text">Mata Kuliah ini adalah {{ $item->deskripsi }}</p>

                                    @if (auth()->user()->role == 'dosen')
                                        <a href="{{ route('penilaian.show', ['penilaian' => $item->id]) }}"
                                            class="btn btn-primary">Show Tugas</a>
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                            data-target="#editUserModal{{ $item->id }}">
                                            Edit
                                        </button>

                                        <form action="{{ route('tugas.destroy', ['tuga' => $item->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-secondary" name="id"
                                                value="{{ $item->id }}" type="submit"
                                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    @else
                                        <a href="{{ route('send-tugas.show', ['send_tuga' => $item->id]) }}"
                                            class="btn btn-primary">Kumpulkan Tugas</a>
                                    @endif
                                </div>
                                <div class="col text-end ">
                                    Deadline : {{ $item->tanggal }} - {{ $item->waktu }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Tambah Tugas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('tugas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id_mata_pelajaran" value="{{ $pelajaran->id }}">
                            <div class="form-group">
                                <label for="title">title</label>
                                <input type="text" class="form-control-file" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">deskripsi</label>
                                <input type="text" class="form-control-file" id="deskripsi" name="deskripsi">
                            </div>
                            <div class="form-group">
                                <label for="tanggal">tanggal</label>
                                <input type="date" class="form-control-file" id="tanggal" name="tanggal">
                            </div>
                            <div class="form-group">
                                <label for="waktu">waktu</label>
                                <input type="time" class="form-control-file" id="waktu" name="waktu">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach ($data as $item)
            <div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit Tugas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('tugas.update', ['tuga' => $item->id]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <input type="hidden" name="id" value="{{ $item->id }}">
                                <div class="form-group">
                                    <label for="title">title</label>
                                    <input type="text" class="form-control-file" id="title"
                                        value="{{ $item->title }}" name="title">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">deskripsi</label>
                                    <input type="text" class="form-control-file" id="deskripsi"
                                        value="{{ $item->deskripsi }}" name="deskripsi">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal">tanggal</label>
                                    <input type="date" class="form-control-file" id="tanggal"
                                        value="{{ $item->tanggal }}" name="tanggal">
                                </div>
                                <div class="form-group">
                                    <label for="waktu">waktu</label>
                                    <input type="time" class="form-control-file" id="waktu"
                                        value="{{ $item->waktu }}" name="waktu">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach








        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var searchInput = document.getElementById('search');

                searchInput.addEventListener('keyup', function() {
                    var search = this.value;
                    var xhr = new XMLHttpRequest();



                    xhr.open('GET', "{{ route('search.user') }}?search=" + search, true);


                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                document.getElementById('user').innerHTML = xhr.responseText;
                            } else {
                                console.error('Terjadi kesalahan: ' + xhr.status);
                                alert('Terjadi kesalahan. Silakan coba lagi.');
                            }
                        }
                    };
                    xhr.send();
                });
            });
        </script>



    @endsection
