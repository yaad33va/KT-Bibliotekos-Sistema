@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Sukurti naują rezervaciją</div>

                    <div class="card-body">
                        {{-- PAKEITIMAS: Pridėtas 'novalidate', kad naršyklė nešokinėtų su angliškais tekstais --}}
                        <form action="{{ route('reservations.store') }}" method="POST" novalidate>
                            @csrf

                            {{-- Book Selection --}}
                            <div class="form-group mb-3">
                                <label for="book_id">Knyga</label>
                                {{-- PAKEITIMAS: Pridėta klasė 'is-invalid', jei yra klaida --}}
                                <select name="book_id" id="book_id" class="form-control @error('book_id') is-invalid @enderror" required>
                                    <option value="">Pasirinkti knygą</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }} ({{ $book->quantity }} laisva)
                                        </option>
                                    @endforeach
                                </select>

                                @error('book_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Return Date --}}
                            <div class="form-group mb-3">
                                <label for="return_date">Grąžinti iki</label>
                                <input type="text" name="return_date" id="return_date"
                                       class="form-control @error('return_date') is-invalid @enderror"
                                       value="{{ old('return_date', now()->addWeeks(1)->format('Y-m-d H:i')) }}"
                                       readonly required>

                                @error('return_date')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Sukurti rezervaciją</button>
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Atšaukti</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
