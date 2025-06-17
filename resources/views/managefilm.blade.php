<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Film</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body class="bg-black text-white" style="background-color: black;">
    <div class="d-flex" style="height: 100vh; width: 100vw; overflow: hidden;">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-3" style="width: 250px;">
            <a href="/managefilm" class="text-white h4 mb-4 d-block text-center" style="text-decoration:none"><b>FIVOY</b></a>
            <ul class="nav flex-column">
                <li class="nav-item mb-3 {{ Request::is('managefilm') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                    <a href="/managefilm" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-film fs-5 me-3"></i> <b>Film</b>
                    </a>
                </li>
                <li class="nav-item mb-3 {{ Request::is('report') ? 'bg-primary rounded-3' : '' }}" style="width: 100%;">
                    <a href="/report" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-flag fs-5 me-3"></i> <b>Report</b>
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

        <div style="flex: 1; overflow-y: auto;">
            {{-- jika berhasil melakukan aksi --}}
            @if (session('status'))
                <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1055;">
                    <div class="toast align-items-center text-white bg-success border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('status') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navbar -->
            <nav class="navbar navbar-dark bg-black px-3">
                <div class="mx-auto" style="width: 700px;">
                    <form action="{{ url('/managefilm') }}" method="GET" class="position-relative" role="search">
                        <input class="form-control pe-5" type="search" name="search" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="position-absolute top-50 end-0 translate-middle-y me-3 border-0 bg-transparent text-secondary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
            </nav>

            <div class="bg-black text-white px-5 pb-5" style="max-height: 90vh; overflow-y: auto;">
                <!-- Tombol Tambah -->
                <div class="text-start my-4">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#filmModal" onclick="openAddModal()">
                        +Tambah Film
                    </button>
                </div>

                <!-- Daftar Film -->
                <div class="d-flex flex-wrap gap-4">
                    @foreach ($films as $filmItem)
                        <div class="d-flex bg-dark rounded p-2" style="width: 23%; min-width: 240px;">
                            <a href="{{ route('film.view', ['id' => $filmItem->id]) }}">
                                <img src="{{ asset('storage/' . $filmItem->foto) }}" alt="Poster" style="width: 100px; height: 150px; object-fit: cover; border-radius: 5px;">
                            </a>
                            <div class="ms-3 d-flex flex-column justify-content-between">
                                <div><h6 class="mb-2 text-white">{{ $filmItem->judul }}</h6></div>
                                <div class="d-flex flex-column gap-1">
                                    <button class="btn btn-primary btn-sm" style="width: 100px;"
                                        onclick="openEditModal({{ $filmItem->id }}, '{{ $filmItem->judul }}', '{{ $filmItem->deskripsi }}', {{ $filmItem->views }}, {{ json_encode($filmItem->genres->pluck('id')) }})">
                                        Edit
                                    </button>

                                    <form action="{{ route('hapus.film', $filmItem->id) }}" method="POST" onsubmit="return confirm('Yakin hapus film?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="width: 100px;">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Modal Form -->
                <div class="modal fade" id="filmModal" tabindex="-1" aria-labelledby="filmModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content bg-dark text-white">
                            <div class="modal-header">
                                <h5 class="modal-title" id="filmModalLabel">Tambah/Edit Film</h5>
                                <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <form id="filmForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="_method" id="formMethod">

                                    <div class="mb-3">
                                        <label for="judul">Judul</label>
                                        <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                                        @error('judul')<div class="text-danger error-message">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="foto">Foto</label>
                                        <input type="file" name="foto" class="form-control" id="fotoInput">
                                        @error('foto')<div class="text-danger error-message">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi">Deskripsi</label>
                                        <input type="text" name="deskripsi" class="form-control" value="{{ old('deskripsi') }}">
                                        @error('deskripsi')<div class="text-danger error-message">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="views">Views</label>
                                        <input type="number" name="views" class="form-control" value="{{ old('views', 0) }}">
                                        @error('views')<div class="text-danger error-message">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="mb-3">
                                        <label>Genre</label>
                                        @foreach ($genres as $item)
                                            <div class="form-check">
                                                <input class="form-check-input genre-checkbox" type="checkbox" name="genre[]" value="{{ $item->id }}"
                                                    {{ (is_array(old('genre')) && in_array($item->id, old('genre'))) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $item->genre }}</label>
                                            </div>
                                        @endforeach
                                        @error('genre')<div class="text-danger error-message">{{ $message }}</div>@enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
                function openAddModal() {
                    document.getElementById('filmForm').action = "{{ route('post.tambah') }}";
                    document.getElementById('formMethod').value = '';
                    document.getElementById('filmModalLabel').innerText = 'Tambah Film';

                    document.querySelector('[name=judul]').value = '';
                    document.querySelector('[name=deskripsi]').value = '';
                    document.querySelector('[name=views]').value = 0;
                    document.getElementById('fotoInput').value = '';
                    document.getElementById('fotoInput').required = true;
                    document.querySelectorAll('.genre-checkbox').forEach(cb => cb.checked = false);
                }

                function openEditModal(id, judul, deskripsi, views, genres) {
                    document.getElementById('filmForm').action = "/managefilm/" + id;
                    document.getElementById('formMethod').value = 'PUT';
                    document.getElementById('filmModalLabel').innerText = 'Edit Film';

                    document.querySelector('[name=judul]').value = judul;
                    document.querySelector('[name=deskripsi]').value = deskripsi;
                    document.querySelector('[name=views]').value = views;
                    document.getElementById('fotoInput').value = '';
                    document.getElementById('fotoInput').required = false;
                    document.querySelectorAll('.genre-checkbox').forEach(cb => {
                        cb.checked = genres.includes(parseInt(cb.value));
                    });

                    var myModal = new bootstrap.Modal(document.getElementById('filmModal'));
                    myModal.show();
                }
            </script>
            <script>
                @if ($errors->any())
                    var myModal = new bootstrap.Modal(document.getElementById('filmModal'));
                    myModal.show();
                @endif
            </script>
            <script>            
                document.getElementById('filmModal').addEventListener('hidden.bs.modal', function () {                
                document.querySelectorAll('.error-message').forEach(function(el) {
                    el.remove();
                });
            });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const toastEl = document.querySelector('.toast');
                    if (toastEl) {
                        const bsToast = new bootstrap.Toast(toastEl, { delay: 2000 });
                        bsToast.show();
                    }
                });
            </script>

        </div>
    </div>
</body>
</html>
