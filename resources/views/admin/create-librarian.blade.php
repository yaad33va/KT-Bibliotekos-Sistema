@extends('layouts.app')

@section('title', 'Sukurti Bibliotekininką')

@section('content')
    <div class="card" style="max-width: 600px; margin: 2rem auto;">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Naujo bibliotekininko informacija</h2>

        <form method="POST" action="{{ route('admin.librarian.store') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Vardas</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            </div>

            <!-- Name -->
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

            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 1.5rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="margin-right: 1rem;">Atšaukti</a>
                <button type="submit" class="btn btn-primary">Sukurti</button>
            </div>
        </form>
    </div>
@endsection
