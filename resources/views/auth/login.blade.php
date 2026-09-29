<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --top-a: #065f46;
            --top-b: #10b981;
            --primary: #059669;
            --primary-dark: #047857;
        }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #064e3b, #047857 55%, #10b981);
            font-family: "Poppins", "Segoe UI", Arial, sans-serif;
        }
        .wrap { width: 100%; max-width: 400px; padding: 16px; }
        h2.logo { color: #fff; text-align: center; margin-bottom: 4px; font-weight: 600; letter-spacing: .5px; }
        p.sub { color: rgba(255,255,255,.85); text-align: center; font-size: .85rem; margin-bottom: 20px; }
        .box { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 12px 32px rgba(0,0,0,.28); }
        .box .head { background: linear-gradient(90deg, var(--top-a), var(--top-b)); color: #fff; text-align: center; padding: 20px; font-size: 1.1rem; font-weight: 500; }
        .box .body { padding: 26px; }
        .form-control { border-radius: 8px; padding: 10px 12px; }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 .2rem rgba(5,150,105,.2); }
        .form-check-input:checked { background-color: var(--primary); border-color: var(--primary); }
        .btn-login { background: var(--primary); color: #fff; border: 0; border-radius: 8px; padding: 10px; font-weight: 500; }
        .btn-login:hover { background: var(--primary-dark); color: #fff; }
    </style>
</head>
<body>
    <div class="wrap">
        <h2 class="logo">Simkari BB</h2>
        <p class="sub">Tracking barang bukti</p>
        <div class="box">
            <div class="head">User Login</div>
            <div class="body">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <input type="text" name="username"
                           class="form-control mb-3 @error('username') is-invalid @enderror"
                           placeholder="Username" value="{{ old('username') }}" autofocus>
                    @error('username')
                        <div class="text-danger small mb-2">{{ $message }}</div>
                    @enderror
                    <input type="password" name="password" class="form-control mb-3" placeholder="Password">
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                    <button class="btn btn-login w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>