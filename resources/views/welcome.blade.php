@extends('layouts.app')

@section('title', 'Sveiki atvykę į Biblioteką!')

@section('content')
    <style>
        .jumbotron {
            background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?fit=crop&w=1200&h=600&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 5rem 2rem;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .jumbotron::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .jumbotron-content {
            position: relative;
            z-index: 2;
        }

        .jumbotron h1 {
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }

        .jumbotron p {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        }
        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1.25rem;
        }
    </style>

    <div class="jumbotron">
        <div class="jumbotron-content">
            <h1>Sveiki atvykę į Bibliotekos Sistemą</h1>
            <p>Darbo autorė: Denisa Valinčiūtė, IFF-3/2</p>
            <div>
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">Eiti į Admino Skydelį</a>
                    @elseif(auth()->user()->hasRole('librarian'))
                        {{-- Corrected link --}}
                        <a href="{{ route('librarian.dashboard') }}" class="btn btn-primary btn-lg">Eiti į Skydelį</a>
                    @else
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg">Peržiūrėti knygas</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Prisijungti</a>
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Registruotis</a>
                @endauth
            </div>
        </div>
    </div>

@endsection
