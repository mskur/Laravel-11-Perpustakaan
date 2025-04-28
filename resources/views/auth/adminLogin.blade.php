<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-dark text-white">
    <div class="card p-4 shadow-lg text-dark" style="width: 350px;">
        <h3 class="text-center">Login Admin</h3>
        <form action="{{ route('loginAdmin') }}" method="POST">
            @csrf
            
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="mb-3">
                <label for="id_admin" class="form-label">ID Admin</label>
                <input type="text" class="form-control" id="id_admin" name="id_admin" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-dark w-100">Login</button>
        </form>
    </div>
</body>
</html>
