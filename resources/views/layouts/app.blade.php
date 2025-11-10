<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bibliotekos Sistema')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
        .navbar { background: linear-gradient(135deg, #2a9d8f 0%, #264653 100%); color: white; padding: 1rem 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar a { color: white; text-decoration: none; margin: 0 1rem; }
        .navbar a:hover { opacity: 0.8; }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .card { background: white; border-radius: 8px; padding: 1.5rem; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin: 1rem 0; }
        .btn { padding: 0.75rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #2a9d8f; color: white; }
        .btn-primary:hover { background: #288a7d; }
        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }
        .btn-danger { background: #dc3545; color: white; }
        .btn-danger:hover { background: #c82333; }
        .btn-success { background: #28a745; color: white; }
        .btn-success:hover { background: #218838; }
        .form-group { margin: 1rem 0; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; }
        .alert { padding: 1rem; border-radius: 4px; margin: 1rem 0; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-danger { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f9f9f9; font-weight: 600; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="{{ route('home') }}" style="font-size: 1.5rem; font-weight: bold;">📚 Bibliotekos Sistema</a>
        </div>
        <div>
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}">Admino skydelis</a>
                    <a href="{{ route('books.index') }}">Knygų valdymas</a>
                @elseif(auth()->user()->hasRole('librarian'))
                    {{-- Corrected link --}}
                    <a href="{{ route('librarian.dashboard') }}">Bibliotekininko skydelis</a>
                    <a href="{{ route('books.index') }}">Knygos</a>
                @else
                    {{-- Regular user links --}}
                    <a href="{{ route('books.index') }}">Peržiūrėti knygas</a>
                    <a href="{{ route('reservations.index') }}">Peržiūrėti rezervacijas</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 1rem;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="padding: 0.5rem 1rem; margin: 0;">Atsijungti</button>
                </form>
            @else
                {{-- Guest links --}}
                <a href="{{ route('books.index') }}">Knygos</a>
                <a href="{{ route('login') }}">Prisijungti</a>
                <a href="{{ route('register') }}">Registruotis</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Klaidos:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
