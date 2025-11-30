@extends('layouts.app')

@section('title', 'Sukurti bibliotekininką')

@section('content')
    <div class="card" style="max-width: 600px; margin: 2rem auto;">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Naujo bibliotekininko informacija</h2>

        {{-- PAKEITIMAS: Pridėtas 'novalidate' atributas, kad naršyklė nerodytų savo angliškų pranešimų --}}
        <form method="POST" action="{{ route('admin.librarian.store') }}" novalidate>
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name">Vardas</label>
                {{-- PAKEITIMAS: Pridėta klasė is-invalid, jei yra klaida --}}
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">

                {{-- PAKEITIMAS: Klaidų atvaizdavimas --}}
                @error('name')
                <span class="text-danger" style="font-size: 0.875em;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Surname -->
            <div class="form-group">
                <label for="surname">Pavardė</label>
                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autofocus autocomplete="surname">

                @error('surname')
                <span class="text-danger" style="font-size: 0.875em;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email">El. paštas</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                <span class="text-danger" style="font-size: 0.875em;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Slaptažodis</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="text-danger" style="font-size: 0.875em;">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Patvirtinkite slaptažodį</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div style="display: flex; justify-content: flex-end; align-items: center; margin-top: 1.5rem;">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="margin-right: 1rem;">Atšaukti</a>
                <button type="submit" class="btn btn-primary">Sukurti</button>
            </div>
        </form>
    </div>
@endsection
