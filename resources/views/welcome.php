<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to FIVOY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: black;
            color: white;
        }

        .fade-in {
            opacity: 0;
            animation: fadeInAnimation 3s ease forwards;
        }

        @keyframes fadeInAnimation {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="#"><b>FIVOY</b></a>
        <div class="ms-auto">
            <a href="/login" class="btn btn-outline-light me-2">Login</a>
            <a href="/register" class="btn btn-light">Register</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container d-flex flex-column justify-content-center align-items-center text-center" style="height: 90vh;">
        <h1 class="display-3 mb-4 fade-in">Welcome to FIVOY</h1>
        <p class="lead mb-5 fade-in" style="animation-delay: 0.5s; animation-duration: 2s;">Website review film</p>
        <div class="fade-in" style="animation-delay: 1s; animation-duration: 2s;">
            <a href="/login" class="btn btn-primary btn-lg me-3 px-5">Login</a>
            <a href="/register" class="btn btn-outline-light btn-lg px-5">Register</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
