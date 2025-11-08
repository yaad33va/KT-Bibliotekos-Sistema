@extends('layouts.app')
@section('title', 'Rezervacijų Sąrašas')
@section('content')
    <div class="card">
        <h2 style="margin-bottom: 1.5rem;">Aktyvios Rezervacijos</h2>
        @if($activeReservations->isEmpty())
            <p>Šiuo metu nėra aktyvių rezervacijų.</p>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Knygos Pavadinimas</th>
                        <th>Vartotojas</th>
                        <th>Rezervacijos Data</th>
                        <th>Grąžinimo Terminas</th>
                        <th>Būsena</th>
                        <th>Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($activeReservations as $reservation)
                        <tr>
                            <td>{{ $reservation->book->title }}</td>
                            <td>{{ $reservation->user->name }} ({{ $reservation->user->email }})</td>
                            <td>{{ $reservation->reservation_date->format('Y-m-d') }}</td>
                            <td>{{ $reservation->return_date->format('Y-m-d') }}</td>
                            <td><span style="font-weight: 500;">{{ $reservation->book_status->value }}</span></td>
                            <td>
                                <form action="{{ route('reservations.update', $reservation) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success" style="padding: 0.5rem 1rem;">Pažymėti Grąžinta</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2rem;">{{ $activeReservations->links() }}</div>
        @endif
    </div>
@endsection
