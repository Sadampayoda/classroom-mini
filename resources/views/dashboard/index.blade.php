@extends('component.app')

@section('content')
    <div class="container mt-4">
        <div class="row d-flex justify-content-center">
            <div class="col mar border-bottom p-3">
                <h1 id="marqueeText">Welcome to Classroom</h1>
            </div>
        </div>
        <div class="row">
            <h1>Dashboard</h1>
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
            @foreach ($data as $item)
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_pelajaran }}</h5>
                            <p class="card-text">Mata Kuliah ini adalah {{ $item->nama_pelajaran }}</p>
                            <a href="{{ route('mata-pelajaran.show', ['mata_pelajaran' => $item->nama_pelajaran]) }}"
                                class="btn btn-primary">Tugas</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>








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



            let position = 0;
            const textElement = document.getElementById('marqueeText');
            const containerWidth = document.querySelector('.col').clientWidth; // Lebar container

            function moveText() {
                position--;
                textElement.style.transform = 'translateX(' + position + 'px)';

                // Jika teks mencapai batas kanan container, kembalikan ke posisi awal
                if (position < -textElement.offsetWidth) {
                    position = containerWidth;
                }

                // Panggil fungsi moveText setiap 10 milidetik
                requestAnimationFrame(moveText);
            }

            // Panggil fungsi moveText untuk memulai animasi
            moveText();
        </script>



    @endsection
