@extends('layouts.app') {{-- Assuming you have a main layout file --}}

@section('content')
    <div class="container">
        <center><h2>Rezervuotų knygų sąrašas</h2></center>
        @auth
            @if(auth()->user()->hasRole('user'))
                <a href="{{ route('reservations.create') }}" class="btn btn-primary">Pridėti naują rezervaciją</a>
            @endif
        @endauth

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        @if(auth()->user()->hasRole('librarian'))
                        <th>Vartotojas</th>
                        @endif
                        <th>Knygos pavadinimas</th>
                        <th>Rezervacijos data</th>
                        <th>Grąžinti iki</th>
                        @if(auth()->user()->hasRole('librarian'))
                        <th>Veiksmai</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($activeReservations as $reservation)
                        <tr>
                            @if(auth()->user()->hasRole('librarian'))
                            <td>{{ $reservation->user->name }}</td>
                            @endif
                            <td>{{ $reservation->book->title }}</td>
                            <td>{{ $reservation->reservation_date->format('Y-m-d H:i') }}</td>
                            <td>{{ $reservation->return_date->format('Y-m-d H:i') }}</td>

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
                            <td colspan="5" class="text-center">Nėra aktyvių rezervacijų</td>
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
