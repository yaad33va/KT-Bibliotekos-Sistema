@extends('layouts.app')

@section('content')
    <style>
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Tamsus fonas */
            display: none; /* Paslėptas pagal nutylėjimą */
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        .custom-modal-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 350px;
            text-align: center;
        }
        .custom-modal-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>

    <div class="container">
        <center><h2>Rezervuotų knygų sąrašas</h2></center>
        @auth
            @if(auth()->user()->hasRole('user'))
                <a href="{{ route('reservations.create') }}" class="btn btn-primary">Pridėti naują rezervaciją</a>
            @endif
        @endauth


        {{-- --------- SEARCH OPTION ------------------ --}}
        {{--
         <div style="margin: 1rem 0;">
             <form action="{{ route('reservations.index') }}" method="GET" style="display: flex; gap: 10px; width: 100%;">
                 <input
                     type="text"
                     name="search"
                     class="form-control"
                     placeholder="Ieškoti pagal knygos pavadinimą{{ auth()->user()->hasRole('librarian') ? ' arba vartotoją' : '' }}..."
                     value="{{ request('search') }}"
                     style="flex: 1;"
                 >
                 <button type="submit" class="btn btn-secondary">Ieškoti</button>
                 @if(request('search'))
                     <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">Išvalyti</a>
                 @endif
             </form>
         </div>
        --}}
        {{-- --------- SEARCH OPTION ------------------ --}}

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
                                        <button type="button"
                                                class="btn btn-danger"
                                                onclick="openReturnModal('{{ route('reservations.update', $reservation) }}')"
                                                style="padding: 0.5rem 1rem;">
                                            Grąžinti
                                        </button>
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

    {{-- MODALINIS LANGAS --}}
    <div id="customReturnModal" class="custom-modal-overlay">
        <div class="custom-modal-box">
            <h4>Patvirtinimas</h4>
            <p style="margin-top: 15px;">Ar tikrai norite pažymėti šią knygą kaip grąžintą?</p>

            <div class="custom-modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="closeReturnModal()">Ne</button>

                <form id="returnForm" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Taip, grąžinti</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openReturnModal(actionUrl) {
            document.getElementById('returnForm').action = actionUrl;
            document.getElementById('customReturnModal').style.display = 'flex';
        }

        function closeReturnModal() {
            document.getElementById('customReturnModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('customReturnModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection
