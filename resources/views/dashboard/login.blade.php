@extends('component.app')

@section('content')
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col mar border-bottom p-3">
                <h1 id="marqueeText">Welcome to Classroom</h1>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            @if (session()->has('error'))
                @include('component.alert', [
                    'message' => session('error'),
                    'status' => 'error',
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
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">Login</h4>
                        <form action="{{ route('dashboard.authentication') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
