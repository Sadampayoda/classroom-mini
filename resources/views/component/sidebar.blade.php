<nav id="sidebar" class="active" style="background: #ff1493">
    @if (auth()->user())
        <h4 class="text-center mt-3  text-light border-bottom p-2">By <span>{{ auth()->user()->name }} -
                {{ auth()->user()->role }}</span></h4>
    @else
        <h5 class="text-center mt-3 text-light border-bottom p-2"><span>Hello </span></h5>
    @endif
    <ul class="list-unstyled components mb-5">
        @if (auth()->user())
            <li class="active">
                <a href="{{ route('dashboard.index') }}"><span class="bi bi-speedometer2 pe-2"></span>Dashboard</a>
            </li>
            <li class="active">
                <a href="{{ route('dashboard.peringkat') }}"><span class="bi bi-bar-chart-fill pe-2"></span>Peringkat</a>
            </li>
            @if (auth()->user()->role == 'mahasiswa')
                <li class="active">
                    <a href="{{ route('dashboard.tingkat') }}"><span
                            class="bi bi-bar-chart-fill pe-2"></span>Progress</a>
                </li>
            @endif
            @if (auth()->user()->role == 'admin')
                <li class="active">
                    <a href="{{ route('mata-pelajaran.index') }}"><span class="bi bi-book pe-2"></span>Mata
                        Kuliah</a>
                </li>
                <li class="active">
                    <a href="{{ route('user-manejement.index') }}"><span class="bi bi-person pe-2"></span>User
                        manajement</a>
                </li>
            @endif
            <li class="active">
                <a href="{{ route('dashboard.logout') }}"><span class="bi bi-door-open pe-2"></span>Logout</a>
            </li>
        @else
            <li class="active">
                <a href="{{ route('dashboard.login') }}"><span class="bi bi-door-open-fill pe-2"></span>Login</a>
            </li>
        @endif


    </ul>


</nav>
