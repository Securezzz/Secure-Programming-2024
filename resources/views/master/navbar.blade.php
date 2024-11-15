<style>
    :root {
        --primary: #664c25;
        --bg: #efe5d8;
        --bgc: #DEC493;
    }

    .active {
        font-weight: bold!important;
    }

    .profile-photo {
        width: 40px; /* Ukuran gambar */
        height: 40px;
        border-radius: 50%; /* Membuat gambar bulat */
        object-fit: cover; /* Memastikan gambar tetap proporsional */
    }
</style>

<!-- Navbar Start -->
<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block" style="background-color: var(--primary)!important">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Jl. Avalon No 9, Jakarta Barat 11530</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">avalonsofteng@gmail.com</a></small>
            </div>
        </div>
    </div>

    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="{{url('/')}}" class="navbar-brand"><h1 class="text-primary display-6" style="color: var(--primary)!important">EcoSavor</h1></a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>

            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{url('/')}}" class="nav-item nav-link {{set_active('/')}}">Beranda</a>
                    <a href="{{url('/buy')}}" class="nav-item nav-link {{set_active('/buy')}}">Beli</a>
                    <a href="{{url('/partner')}}" class="nav-item nav-link {{set_active('/partner')}}">Partner</a>
                </div>

                @if (Route::has('login'))
                <div class="d-flex m-3 me-0">
                    <a href="{{url('mycart')}}" class="position-relative me-4 my-auto">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                    </a>

                    @auth
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex align-items-center" data-bs-toggle="dropdown" style="color: var(--primary)!important">
                            <!-- Foto Profil -->
                            @if(Auth::user()->profile_photo)
                                <img src="{{ asset('storage/profile_photos/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="profile-photo me-2">
                            @else
                                <img src="{{ asset('img/avatar.jpg') }}" alt="Default Profile Photo" class="profile-photo me-2">
                            @endif
                            
                            <!-- Nama Pengguna -->
                            {{-- <span>{{ Auth::user()->name }}</span> --}}
                        </a>

                        <div class="dropdown-menu m-0 bg-white rounded-0">
                            <a href="{{route('profile.edit')}}" class="dropdown-item">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ url('/login') }}" class="position-relative me-4 my-auto">
                        <i class="bi bi-box-arrow-in-left fa-2x"></i>
                    </a>
                    @endauth
                </div>
                @endif
            </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->
