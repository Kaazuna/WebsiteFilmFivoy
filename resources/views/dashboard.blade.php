<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
            background-color: black;
            color: white;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #212529;
            padding: 1rem;
        }

        .main-content {
            margin-left: 250px;
            height: 100vh;
            overflow-y: auto;
            padding: 1rem;
            background-color: black;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
            user-select: none;
        }

        .scroll-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .scroll-left {
            left: 0;
        }

        .scroll-right {
            right: 0;
        }

        .film-row {
            overflow-x: auto;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .film-row::-webkit-scrollbar {
            display: none;
        }

        .film-card {
            flex: 0 0 auto;
            width: 150px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="/dashboard" class="text-white h4 mb-4 d-block text-center text-decoration-none"><b>FIVOY</b></a>
        <ul class="nav flex-column">
            <li class="nav-item mb-3 {{ Request::is('dashboard') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                <a href="/dashboard" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                    <i class="bi bi-film fs-5 me-3"></i> <b>Film</b>
                </a>
            </li>
            <li class="nav-item mb-3 {{ Request::is('favorites') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                <a href="{{ session('user') ? '/favorites' : route('login') }}"
                    class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                    <i class="bi bi-heart fs-5 me-3"></i> <b>Favorites</b>
                </a>
            </li>
            <li class="nav-item mb-3 {{ Request::is('profile') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                <a href="{{ session('user') ? '/profile' : route('login') }}"
                    class="nav-link text-white py-2 fs-6 d-flex align-items-center">
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
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-dark bg-black px-3">
            <div class="d-flex justify-content-start w-100 align-items-center">
                @if (session()->has('user'))
                    <h5>Selamat Datang, {{ session('user.name') }}</h5>
                    {{-- <span class=" fw-semibold">Selamat Datang, {{ session('user.name') }}</span> --}}
                @endif
                <form action="{{ route('dashboard') }}" method="GET" class="position-relative ms-4"
                    style="max-width: 500px; width: 100%;">
                    <input type="search" name="search" class="form-control pe-5" placeholder="Search..."
                        value="{{ request('search') }}">
                    <button type="submit"
                        class="btn position-absolute top-50 end-0 translate-middle-y me-3 p-0 border-0 bg-transparent text-secondary">
                        <i class="bi bi-search fs-5"></i>
                    </button>
                </form>
            </div>
        </nav>


        <!-- Cari film -->
        @if (request()->has('search') && request('search') != '')
            <div class="p-4">
                <h5 class="mb-4">Films</h5>
                <div class="d-flex flex-wrap gap-1">
                    @forelse ($films as $film)
                        <div class="film-card rounded p-2" style="width: 150px;">
                            <a href="{{ session('user') ? route('film.view', ['id' => $film->id]) : route('login') }}">
                                <img src="{{ asset('storage/' . $film->foto) }}" alt="Poster"
                                    class="img-fluid rounded bg-black"
                                    style="height: 200px; object-fit: contain; width: 100%;" />
                            </a>
                            <h6 class="mt-2 text-white text-center" style="font-size: 0.8rem;">{{ $film->judul }}</h6>
                        </div>
                    @empty
                        <p>Tidak menemukan film</p>
                    @endforelse
                </div>
            </div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5>Films</h5>
                <a href="{{ route('films.all') }}" class="btn btn-outline-light btn-sm">Lihat</a>
            </div>

            <div class="position-relative mb-5">
                <button class="scroll-btn scroll-left"><i class="bi bi-chevron-left"></i></button>
                <div class="film-row d-flex gap-3">
                    @foreach ($films as $film)
                        <div style="flex: 0 0 auto; width: 150px;">
                            <a href="{{ route('film.view', ['id' => $film->id]) }}">
                                <img src="{{ asset('storage/' . $film->foto) }}" alt="Poster"
                                    class="img-fluid rounded bg-black" style="height: 200px; object-fit: contain;" />
                            </a>
                            <h6 class="mt-2 text-white text-center">{{ $film->judul }}</h6>
                        </div>
                    @endforeach
                </div>
                <button class="scroll-btn scroll-right"><i class="bi bi-chevron-right"></i></button>
            </div>

            @foreach ($genres as $genre)
                <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
                    <h5>{{ $genre->genre }} Movies</h5>
                    <a href="{{ route('genre.films', ['id' => $genre->id]) }}"
                        class="btn btn-outline-light btn-sm">Lihat</a>
                </div>

                <div class="position-relative mb-5">
                    <button class="scroll-btn scroll-left"><i class="bi bi-chevron-left"></i></button>
                    <div class="film-row d-flex gap-3">
                        @forelse ($genre->films as $film)
                            <div style="flex: 0 0 auto; width: 150px;">
                                <a href="{{ route('film.view', ['id' => $film->id]) }}">
                                    <img src="{{ asset('storage/' . $film->foto) }}" alt="Poster"
                                        class="img-fluid rounded bg-black"
                                        style="height: 200px; object-fit: contain;" />
                                </a>
                                <h6 class="mt-2 text-white text-center">{{ $film->judul }}</h6>
                            </div>
                        @empty
                            <p>Genre ini belum memiliki film.</p>
                        @endforelse
                    </div>
                    <button class="scroll-btn scroll-right"><i class="bi bi-chevron-right"></i></button>
                </div>
            @endforeach
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.scroll-btn').forEach(button => {
            button.addEventListener('click', () => {
                const container = button.parentElement.querySelector('.film-row');
                const scrollAmount = 150;
                if (button.classList.contains('scroll-left')) {
                    container.scrollBy({
                        left: -scrollAmount,
                        behavior: 'smooth'
                    });
                } else {
                    container.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>

</html>
