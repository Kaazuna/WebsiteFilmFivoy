<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

</head>

<body>
    <div class="d-flex" style="height: 100vh; overflow: hidden; background-color:black">
        <!-- Sidebar -->
        <div class="sidebar bg-dark text-white p-3" style="width: 250px;">
            <a href="/managefilm" class="text-white h4 mb-4 d-block text-center"
                style="text-decoration:none"><b>FIVOY</b></a>
            <ul class="nav flex-column">
                <li class="nav-item mb-3 {{ Request::is('managefilm') ? 'bg-primary rounded-3' : '' }}"
                    style="width: 100%;">
                    <a href="/managefilm" class="nav-link text-white py-2 fs-6 d-flex align-items-center">
                        <i class="bi bi-film fs-5 me-3"></i> <b>Film</b>
                    </a>
                </li>
                <li class="nav-item mb-3 {{ Request::is('report') ? 'bg-primary rounded-3' : '' }}"
                    style="width: 100%;">
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

        <div class="flex-grow-1 d-flex flex-column">
            <!-- Main Content -->
            <div class="bg-black text-white px-5 py-4" style="overflow-y: auto;">
                <h5>Daftar Komentar Dilaporkan</h5>

                @if ($lapor->count() > 0)
                    <table class="table table-dark table-striped mt-4">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengguna</th>
                                <th>Film</th>
                                <th>Komentar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lapor as $index => $komen)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $komen->user->name }}</td>
                                    <td>{{ $komen->film->judul }}</td>
                                    <td>{{ $komen->komen }}</td>
                                    <td>
                                        <form action="{{ route('hapus.komen.lapor', $komen->id) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                                Hapus Komentar</button>
                                        </form>
                                        <form action="{{ route('tolak.laporan', $komen->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            <button class="btn btn-secondary btn-sm"onclick="return confirm('Tolak laporan?')">
                                                Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h6 class="mt-4">Tidak ada komentar yang dilaporkan saat ini.</h6>
                @endif
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
