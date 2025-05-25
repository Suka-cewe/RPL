<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="LibZone - Sistem Perpustakaan SDN 019 Penajam">
    <meta name="author" content="LibZone">

    <title>LibZone - Login Admin</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Nunito", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f8f9fc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('{{ asset('images/perpustakaan.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 0;
        }
        .center-wrapper, .card-login-custom {
            position: relative;
            z-index: 1;
        }
        .center-wrapper {
            width: 100vw;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login-custom {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background: rgba(255, 255, 255, 0.97);
            border-radius: 1rem;
            max-width: 900px;
            width: 100%;
        }
        .login-left {
            background: none;
            border-radius: 1rem 0 0 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
        }
        .login-logo-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .login-logo-row img {
            max-width: 70px;
            height: auto;
        }
        .login-logo-row .libzone-title {
            font-size: 2rem;
            font-weight: 700;
            color: #4e73df;
            margin: 0;
        }
        .login-left .perpus-img {
            max-width: 120px;
            width: 100%;
            margin-top: 1.5rem;
        }
        .login-right {
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-back {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 2;
        }
        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }
        .form-control {
            transition: all 0.3s ease;
        }
        .form-control:focus {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .text-gray-900 {
            color: #4e73df !important;
        }
        @media (max-width: 991.98px) {
            .card-login-custom {
                flex-direction: column !important;
            }
            .login-left, .login-right {
                border-radius: 1rem 1rem 0 0;
                padding: 2rem 1rem;
            }
            .login-left {
                border-radius: 1rem 1rem 0 0;
            }
        }
        @media (max-width: 767.98px) {
            .card-login-custom {
                max-width: 98vw;
            }
            .login-left, .login-right {
                padding: 1.5rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <a href="{{ route('login') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div class="center-wrapper">
        <div class="card card-login-custom d-flex flex-row">
            <div class="login-left col-lg-5 col-md-5 col-sm-12">
                <div class="login-logo-row">
                    <img src="{{ asset('images/logo_sekolah.png') }}" alt="Logo Sekolah">
                    <span class="libzone-title">LibZone</span>
                </div>
                {{-- <img src="{{ asset('images/perpustakaan.png') }}" alt="Perpustakaan" class="perpus-img"> --}}
            </div>
            <div class="login-right col-lg-7 col-md-7 col-sm-12">
                <div class="text-center mb-4">
                    <p class="mb-2">Sistem Perpustakaan SDN 019 Penajam</p>
                    <h5 class="mb-4">Login Admin</h5>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form class="user" method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <input type="hidden" name="role" value="admin">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-user" id="nip" name="nip" placeholder="NIP (Nomor Induk Pegawai)" value="{{ old('nip') }}" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox small">
                            <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                            <label class="custom-control-label" for="remember">Ingat Saya</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                </form>
                <hr>
                <div class="text-center">
                    <small class="text-muted">&copy; 2025 B3 ITK | Perpustakaan SDN 019 Penajam</small>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 