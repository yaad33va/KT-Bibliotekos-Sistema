@extends('layouts.app') {{-- Assuming you have a main layout file --}}

@section('content')
    <div class="container">
        <h1>Active Reservations</h1>
        @auth
            @if(auth()->user()->hasRole('librarian'))
                <a href="{{ route('reservations.create') }}" class="btn btn-primary">Pridėti Naują Rezervaciją</a>
            @endif
        @endauth

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Book Title</th>
                        <th>Reservation Date</th>
                        <th>Return By</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($activeReservations as $reservation)
                        <tr>
                            <td>{{ $reservation->user->name }}</td>
                            <td>{{ $reservation->book->title }}</td>
                            <td>{{ $reservation->reservation_date->format('Y-m-d') }}</td>
                            <td>{{ $reservation->return_date->format('Y-m-d') }}</td>

                            @auth
                                @if(auth()->user()->hasRole('librarian'))
                                    <td style="display: flex; gap: 0.5rem;">
                                        <form action="{{ route('reservations.update', $reservation) }}" method="POST" onsubmit="return confirm('Ar tikrai norite grąžinti šią knygą?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">Grąžinti</button>
                                        </form>
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No active reservations found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $activeReservations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
