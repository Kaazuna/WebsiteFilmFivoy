<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Favorites</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-black text-white">
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="bg-dark text-white p-3 position-fixed top-0 start-0 vh-100 d-flex flex-column"
            style="width: 250px;">
            <a href="/dashboard" class="text-white h4 mb-4 d-block text-center text-decoration-none"><b>FIVOY</b></a>
            <ul class="nav flex-column">
                <li class="nav-item mb-3 {{ Request::is('dashboard') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                    <a href="/dashboard" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-film fs-5 me-3"></i> <b>Film</b>
                    </a>
                </li>
                <li class="nav-item mb-3 {{ Request::is('favorites') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                    <a href="{{ session('user') ? '/favorites' : route('login') }}" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-heart fs-5 me-3"></i> <b>Favorites</b>
                    </a>
                </li>
                <li class="nav-item mb-3 {{ Request::is('profile') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                    <a href="{{ session('user') ? '/profile' : route('login') }}" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-person fs-5 me-3"></i> <b>Account</b>
                    </a>
                </li>
            </ul>

            <div class="mt-auto">            
                <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Logout</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 ms-250" style="margin-left: 250px; height: 100vh; overflow-y: auto;">
            <!-- Navbar -->
            <nav class="navbar navbar-dark bg-black px-3 py-3">
                <div class="mx-auto" style="width: 700px;">
                    <form action="{{ route('favorites') }}" method="GET" class="position-relative" role="search">
                        <input class="form-control pe-5" type="search" name="search" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="position-absolute top-50 end-0 translate-middle-y me-3 border-0 bg-transparent text-secondary">
                            <i class="bi bi-search fs-5"></i>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Film Content -->
            <div class="p-4">
                <h5 class="mb-4">{{ session('user')['name'] }}, Film yang kamu sukai:</h5>
                <div class="d-flex flex-wrap gap-1">
                    @forelse ($films as $film)
                        <div class="film-card rounded p-2" style="width: 150px;">
                            <a href="{{ route('film.view', ['id' => $film->id]) }}">
                                <img src="{{ asset('storage/' . $film->foto) }}" alt="Poster"
                                    class="img-fluid rounded bg-black"
                                    style="height: 200px; object-fit: contain; width: 100%;" />
                            </a>
                            <h6 class="mt-2 text-white text-center" style="font-size: 0.8rem;">{{ $film->judul }}</h6>
                        </div>
                    @empty
                        <p>Tidak ada film yang kamu cari</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
