@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pažymėti knygą kaip grąžintą</div>

                    <div class="card-body">
                        <p><strong>Book Title:</strong> {{ $reservation->book->title }}</p>
                        <p><strong>User:</strong> {{ $reservation->user->name }}</p>
                        <p><strong>Return By:</strong> {{ $reservation->return_date->format('Y-m-d') }}</p>

                        <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="alert alert-warning" role="alert">
                                Ar tikrai norite pažymėti šią knygą kaip grąžintą?
                            </div>

                            <button type="submit" class="btn btn-success">Patvirtinti grąžinimą</button>
                            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Atšaukti</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
