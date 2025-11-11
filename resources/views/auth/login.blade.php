@extends('layouts.app')

@section('title', 'Prisijungti')

@section('content')
    <div class="card" style="max-width: 500px; margin: 2rem auto;">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Prisijungti prie paskyros</h2>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">El. paštas</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Slaptažodis</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <!-- Remember Me -->
            <div class="form-group" style="display: flex; align-items: center;">
                <input id="remember_me" type="checkbox" name="remember" style="width: auto; margin-right: 0.5rem;">
                <label for="remember_me" style="margin: 0;">Prisiminti mane</label>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                <a href="{{ route('register') }}" class="btn-link">Neturite paskyros? Registruokitės</a>
                <button type="submit" class="btn btn-primary">Prisijungti</button>
            </div>

        </form>
    </div>
    <style>.btn-link { color: #667eea; text-decoration: none; } .btn-link:hover { text-decoration: underline; }</style>
@endsection
