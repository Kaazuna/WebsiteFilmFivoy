<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      font-family: 'Inter', sans-serif;
    }
    .register-container {
      min-height: 100vh;
    }
    .form-box {
      background-color: #111;
      padding: 40px;
      border-radius: 8px;
      color: white;
      box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
    }
    .form-label {
      font-weight: 600;
    }
    .form-control {
      background-color: #222;
      border: none;
      color: white;
    }
    .form-control:focus {
      background-color: #222;
      color: white;
      box-shadow: none;
    }
    .btn-dark-custom {
      background-color: #2b2b2b;
      color: white;
    }
    .btn-dark-custom:hover {
      background-color: #3b3b3b;
    }
    .small-text a {
      color: #4d6fff;
      text-decoration: none;
    }
    .small-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container d-flex justify-content-center align-items-center register-container">
    <div class="form-box w-100" style="max-width: 400px;">
      <h2 class="text-center mb-4">REGISTER</h2>
      <form method="POST" action="{{ route('register.store') }}">
        @csrf
          {{-- jika berhasil tampilkan alert --}}
            @if (session('success'))
                <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1055;">
                    <div class="toast align-items-center text-white bg-success border-0 show shadow" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session('success') }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>
            @endif
          {{-- form --}}
        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control" id="name" name="name" required>
          @error('name')
            <p>{{$message}}</p>            
          @enderror<br>
        </div>
        
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" required>
          @error('email')
            <p>{{$message}}</p>            
          @enderror<br>
        </div>
        
        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
          @error('password')
            <p>{{$message}}</p>            
          @enderror<br>
        </div>

        <button type="submit" class="btn btn-dark-custom w-100">Register</button> <br> <br>
        <a href="/login" class="btn btn-dark-custom w-100">Login</a>        
      </form>
      
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          var toastElList = [].slice.call(document.querySelectorAll('.toast'))
          var toastList = toastElList.map(function (toastEl) {
              return new bootstrap.Toast(toastEl, { delay: 2000 }); 
          });
          toastList.forEach(toast => toast.show());
      });
  </script>
</body>
</html>
