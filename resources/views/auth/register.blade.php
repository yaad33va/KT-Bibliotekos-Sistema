@extends('layouts.app')

@section('title', 'Registracija')

@section('content')
    <div class="card" style="max-width: 500px; margin: 2rem auto;">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Sukurti Paskyrą</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Vardas</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>
            <div class="form-group">
                <label for="name">Pavardė</label>
                <input id="surname" type="text" name="surname" value="{{ old('surname') }}" required autofocus autocomplete="surname">
            </div>
            <!-- Email Address -->
            <div class="form-group">
                <label for="email">El. paštas</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Slaptažodis</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Patvirtinkite slaptažodį</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem;">
                <a href="{{ route('login') }}" class="btn-link">Jau turite paskyrą? Prisijunkite</a>
                <button type="submit" class="btn btn-primary">Registruotis</button>
            </div>
        </form>
    </div>
    <style>.btn-link { color: #667eea; text-decoration: none; } .btn-link:hover { text-decoration: underline; }</style>
@endsection
