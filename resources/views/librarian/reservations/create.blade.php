@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create New Reservation</div>

                    <div class="card-body">
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf

                            {{-- Book Selection --}}
                            <div class="form-group mb-3">
                                <label for="book_id">Book</label>
                                <select name="book_id" id="book_id" class="form-control" required>
                                    <option value="">Select a book</option>
                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                            {{ $book->title }} ({{ $book->quantity }} available)
                                        </option>
                                    @endforeach
                                </select>
                                @error('book_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- User Selection --}}
                            <div class="form-group mb-3">
                                <label for="user_id">User</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Select a user</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Return Date --}}
                            <div class="form-group mb-3">
                                <label for="return_date">Return By</label>
                                <input type="date" name="return_date" id="return_date" class="form-control" value="{{ old('return_date', now()->addWeeks(2)->format('Y-m-d')) }}" required>
                                @error('return_date')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create Reservation</button>
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
