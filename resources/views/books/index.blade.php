@extends('layouts.app')
@section('title', 'Knygų Sąrašas')
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

    <div class="card">
        <div style="display: flex; align-items: center; margin-bottom: 1.5rem;">
            <div style="flex: 1;"></div>

            <h2 style="margin: 0; text-align: center; flex: 1;">Knygų katalogas</h2>

            <div style="flex: 1; display: flex; justify-content: flex-end;">
                @auth
                    @if(auth()->user()->hasRole('librarian'))
                        <a href="{{ route('books.create') }}" class="btn btn-primary">Pridėti naują Knygą</a>
                    @endif
                @endauth
            </div>
        </div>
        {{-- --------- SEARCH OPTION ------------------ --}}
        {{-- <div style="margin: 1rem 0;">
            <form action="{{ route('books.index') }}" method="GET" style="display: flex; gap: 10px;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Ieškoti pagal pavadinimą, autorių ar žanrą..."
                    value="{{ request('search') }}"
                    style="flex: 1;"
                >
                <button type="submit" class="btn btn-secondary">Ieškoti</button>
                @if(request('search'))
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Išvalyti</a>
                @endif
            </form>
        </div> --}}
        {{-- --------- SEARCH OPTION ------------------ --}}
        @if($books->isEmpty())
            <p class="text-center text-muted my-5">Knygų katalogas tuščias.</p>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Pavadinimas</th>
                        <th>Autorius</th>
                        <th>Žanras</th>
                        <th style="white-space: nowrap;">Leidimo Data</th>
                        <th style="white-space: nowrap;">Laisvas Kiekis</th>
                        <th style="width: 40%;">Aprašymas</th>
                        @auth
                            @if(auth()->user()->hasRole('librarian'))
                                <th style="width: 200px;">Veiksmai</th>
                            @endif
                        @endauth
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td style="font-weight: 600; color: #264653; vertical-align: top;">{{ $book->title }}</td>
                            <td style="vertical-align: top;">{{ $book->author }}</td>
                            <td style="vertical-align: top;">{{ $book->genre }}</td>

                            <td style="vertical-align: top; white-space: nowrap;">{{ $book->release_date->format('Y-m-d') }}</td>

                            <td style="vertical-align: top;">
                                <span class="badge {{ $book->book_count > 0 ? 'bg-success' : 'bg-danger' }}"
                                      style="padding: 0.3rem 0.6rem; border-radius: 20px; color: black; font-size: 0.85rem;">
                                    {{ $book->book_count }}
                                </span>
                            </td>
                            <td style="vertical-align: top;">
                                <div style="color: #555;">
                                    {{ $book->book_description }}
                                </div>
                            </td>
                            @auth
                                @if(auth()->user()->hasRole('librarian'))
                                    <td style="vertical-align: top;">
                                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                                            <a href="{{ route('books.edit', $book) }}" class="btn btn-secondary btn-sm" style="font-size: 0.8rem;">Redaguoti</a>

                                            <button type="button"
                                                    class="btn btn-danger btn-sm"
                                                    style="font-size: 0.8rem;"
                                                    onclick="openDeleteModal('{{ route('books.destroy', $book) }}')">
                                                Ištrinti
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 2rem;">{{ $books->links() }}</div>
        @endif
    </div>

    <div id="customDeleteModal" class="custom-modal-overlay">
        <div class="custom-modal-box">
            <h4>Patvirtinimas</h4>
            <p style="margin-top: 15px;">Ar tikrai norite ištrinti šią knygą?</p>

            <div class="custom-modal-buttons">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Ne</button>

                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Taip</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openDeleteModal(actionUrl) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('customDeleteModal').style.display = 'flex';
        }

        function closeDeleteModal() {
            document.getElementById('customDeleteModal').style.display = 'none';
        }

        window.onclick = function(event) {
            var modal = document.getElementById('customDeleteModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
@endsection
