@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Mark Book as Returned</div>

                    <div class="card-body">
                        <p><strong>Book Title:</strong> {{ $reservation->book->title }}</p>
                        <p><strong>User:</strong> {{ $reservation->user->name }}</p>
                        <p><strong>Return By:</strong> {{ $reservation->return_date->format('Y-m-d') }}</p>

                        <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="alert alert-warning" role="alert">
                                Are you sure you want to mark this book as returned? This action cannot be undone.
                            </div>

                            <button type="submit" class="btn btn-success">Confirm Return</button>
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
