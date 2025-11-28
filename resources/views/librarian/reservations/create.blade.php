@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Sukurti naują rezervaciją</div>

                    <div class="card-body">
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf

                            {{-- Book Selection --}}
                            <div class="form-group mb-3">
                                <label for="book_id">Knyga</label>
                                <select name="book_id" id="book_id" class="form-control" required>
                                    <option value="">Pasirinkti knygą</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }} ({{ $book->quantity }}laisva)
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Return Date --}}
                            <div class="form-group mb-3">
                                <label for="return_date">Grąžinti iki</label>
                                <input type="date" name="return_date" id="return_date" class="form-control" value="{{ old('return_date', now()->addWeeks(1)->format('Y-m-d')) }}" readonly required>
                                @error('return_date')
                                <div class="text-danger">{{ $message }}</div>
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
