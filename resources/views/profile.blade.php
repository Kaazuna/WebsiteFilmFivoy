<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

</head>

<body class="bg-black text-white" style="background-color: black;">
    <div class="d-flex" style="height: 100vh; overflow: hidden;">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-3" style="width: 250px;">
            <a href="/dashboard" class="text-white h4 mb-4 d-block text-center"
                style="text-decoration:none"><b>FIVOY</b></a>
            <ul class="nav flex-column">
                <li class="nav-item mb-3 {{ Request::is('dashboard') ? 'bg-primary rounded-3' : '' }}"
                    style="width: 100%;">
                    <a href="/dashboard" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-film fs-5 me-3"></i> <b>Film</b>
                    </a>
                </li>
                <li class="nav-item mb-3 {{ Request::is('favorites') ? 'bg-primary rounded-3' : '' }}"
                    style="width: 100%;">
                    <a href="{{ session('user') ? '/favorites' : route('login') }}"
                        class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-heart fs-5 me-3"></i> <b>Favorites</b>
                    </a>
                </li>
                {{-- sidebar akun --}}
                <li class="nav-item mb-3 {{ Request::is('profile') ? 'bg-primary rounded-3' : '' }}"
                    style="width: 100%;">
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
        <div class="flex-grow-1 d-flex flex-column">
            <!-- Profile Content -->
            <div class="container my-4 d-flex justify-content-center align-items-center" style="min-height: 80vh;">
                <div class="card bg-dark text-white p-4" style="width: 400px;">

                    <!-- Judul Edit Profile di tengah -->
                    <h2 class="text-center mb-4">Edit Profile</h2>

                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <p><b>Nama:</b> {{ $user->name ?? '-' }}</p>
                            <p><b>Gender:</b> {{ $user->gender ?? '-' }}</p>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#editProfileModal">Edit Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-white text-dark">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="text" class="form-control" name="name" placeholder="--inputkan nama kamu--"
                            required><br>
                        <select class="form-control" name="gender" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                            </option>
                            <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan
                            </option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
