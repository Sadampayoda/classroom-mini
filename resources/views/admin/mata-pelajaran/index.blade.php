@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <h1>Mata Pelajaran </h1>
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
                    Tambah Mata Pelajaran
                </button>
            </div>
            <div class="col-6 mb-2 ">

                <div class="form-inline float-right">
                    <input class="form-control mr-sm-2" type="search" id="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit">Search</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="input-group mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Mata Pelajaran</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="mata-pelajaran">
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $item->nama_pelajaran }}</td>
                                    
                                    <td>
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                            data-target="#editUserModal{{ $item->id }}">
                                            Edit
                                        </button>

                                        <form
                                            action="{{ route('mata-pelajaran.destroy', ['mata_pelajaran' => $item->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-outline-secondary" type="submit"
                                                onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $data->onEachSide(5)->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Tambah Mata Pelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('mata-pelajaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="nama_pelajaran">Nama Mata Pelajara</label>
                            <input type="text" class="form-control-file" id="nama_pelajaran" name="nama_pelajaran">
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
    {{-- <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script> --}}



    @foreach ($data as $item)
        <div class="modal fade" id="editUserModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit Mata Pelajaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('mata-pelajaran.update', ['mata_pelajaran' => $item->id]) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama_pelajaran">Nama pelajaran:</label>
                                <input type="text" class="form-control" id="nama_pelajaran" name="nama_pelajaran" value="{{ $item->nama_pelajaran }}" required>
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



                xhr.open('GET', "{{ route('search.mata-pelajaran') }}?search=" + search, true);


                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            document.getElementById('mata-pelajaran').innerHTML = xhr.responseText;
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
