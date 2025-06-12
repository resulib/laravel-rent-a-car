<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <title>Admin Giriş</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-container h3 {
            margin-bottom: 25px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h3 class="text-center">Admin Panel Girişi</h3>

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-poçt</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Şifrə</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button type="submit" class="btn btn-dark w-100">Giriş et</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
