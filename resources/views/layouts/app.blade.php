<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bibliotekos Sistema')</title>

    {{-- Importuojame Google Font 'Nunito' gražesniam tekstui --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    {{-- FontAwesome ikonoms (jei prireiktų ateityje) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #2a9d8f;
            --primary-dark: #218276;
            --secondary: #264653;
            --accent: #e9c46a;
            --danger: #e76f51;
            --light: #f8f9fa;
            --dark: #343a40;
            --shadow-sm: 0 2px 4px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --radius: 10px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f0f2f5;
            color: #4a5568;
            line-height: 1.6;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            padding: 1rem 0;
            box-shadow: 0 4px 20px rgba(42, 157, 143, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            color: white;
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links { display: flex; gap: 20px; align-items: center; }

        .nav-links a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
            position: relative;
        }

        .nav-links a:hover {
            color: white;
            transform: translateY(-1px);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s;
        }

        .nav-links a:hover::after { width: 100%; }

        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            padding: 0.5rem 1.2rem !important;
            border-radius: 20px;
        }
        .logout-btn:hover { background: rgba(255,255,255,0.3); }

        /* Container & Layout */
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 2rem; }

        /* Card Styling */
        .card {
            background: white;
            border-radius: var(--radius);
            padding: 2rem;
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
            border: none;
        }

        /* Buttons */
        .btn {
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
            transition: all 0.2s ease;
            font-size: 0.95rem;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .btn:active { transform: translateY(0); }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }

        .btn-secondary { background: #6c757d; color: white; }
        .btn-secondary:hover { background: #5a6268; }

        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #c0392b; }

        .btn-outline-dark {
            background: transparent;
            border: 2px solid var(--dark);
            color: var(--dark);
        }
        .btn-outline-dark:hover { background: var(--dark); color: white; }

        /* Forms */
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--secondary); font-size: 0.9rem; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--primary);
            background-color: #fff;
        }

        /* Alerts */
        .alert { padding: 1rem 1.5rem; border-radius: 8px; margin: 1rem 0; position: relative; }
        .alert-success { background: #d1e7dd; color: #0f5132; border-left: 5px solid #198754; }
        .alert-danger { background: #f8d7da; color: #842029; border-left: 5px solid #dc3545; }

        /* Tables */
        table { width: 100%; border-collapse: separate; border-spacing: 0; margin-bottom: 1rem; }
        th {
            background: #f8f9fa;
            font-weight: 700;
            color: var(--secondary);
            text-align: left;
            padding: 1rem;
            border-bottom: 2px solid #e9ecef;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        td { padding: 1rem; border-bottom: 1px solid #eee; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #fafafa; }

        /* Lists */
        ul { list-style: none; }
    </style>
</head>
<body>
<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <i class="fas fa-book-open"></i> Bibliotekos Sistema
        </a>

        <div class="nav-links">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}">Admino skydelis</a>
                    <a href="{{ route('books.index') }}">Knygų valdymas</a>
                @elseif(auth()->user()->hasRole('librarian'))
                    <a href="{{ route('librarian.dashboard') }}">Bibliotekininko skydelis</a>
                    <a href="{{ route('books.index') }}">Knygos</a>
                @else
                    <a href="{{ route('books.index') }}">Knygos</a>
                    <a href="{{ route('reservations.index') }}">Mano rezervacijos</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn logout-btn">
                        Atsijungti <i class="fas fa-sign-out-alt" style="margin-left: 5px;"></i>
                    </button>
                </form>
            @else
                <a href="{{ route('books.index') }}">Knygos</a>
                <a href="{{ route('login') }}">Prisijungti</a>
                <a href="{{ route('register') }}" class="btn" style="background: white; color: var(--secondary); padding: 0.5rem 1rem;">Registruotis</a>
            @endauth
        </div>
    </div>
</nav>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <div style="font-weight: bold; margin-bottom: 5px;">
                <i class="fas fa-exclamation-circle"></i> Klaidos:
            </div>
            <ul style="padding-left: 1.2rem; list-style: disc;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @yield('content')
</div>
</body>
</html>
