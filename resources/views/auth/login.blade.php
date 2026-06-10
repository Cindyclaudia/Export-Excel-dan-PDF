<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Akademik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.3);
        }
        .login-title {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 5px;
        }
        .login-subtitle {
            color: rgba(255,255,255,0.5);
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .form-control {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 10px;
            color: #fff;
            padding: 12px 15px;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.15);
            border-color: #e94560;
            color: #fff;
            box-shadow: 0 0 0 0.2rem rgba(233,69,96,0.25);
        }
        .form-control::placeholder { color: rgba(255,255,255,0.4); }
        .form-label { color: rgba(255,255,255,0.8); font-size: 14px; }
        .btn-login {
            background: linear-gradient(135deg, #e94560, #c62a47);
            border: none;
            border-radius: 10px;
            color: #fff;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(233,69,96,0.4);
            color: #fff;
        }
        .icon-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #e94560, #c62a47);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .alert-danger {
            background: rgba(233,69,96,0.2);
            border: 1px solid rgba(233,69,96,0.4);
            color: #ff6b8a;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="icon-wrapper">
            <i class="fas fa-graduation-cap fa-2x text-white"></i>
        </div>
        <h1 class="login-title">Sistem Akademik</h1>
        <p class="login-subtitle">Universitas Teknologi Bandung</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label"><i class="fas fa-lock me-2"></i>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-login">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </form>
        <div style="color: rgba(255,255,255,0.6); text-align: center; margin-top: 20px; font-size: 14px;">
    Belum punya akun? <a href="{{ route('register') }}" style="color: #e94560; text-decoration: none; font-weight: 600;">Daftar di sini</a>
</div>
    </div>
</body>
</html>