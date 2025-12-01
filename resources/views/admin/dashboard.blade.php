@extends('layouts.app')

@section('title', 'Admino Skydelis')

@section('content')
    <style>
        .custom-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2>Bibliotekininkų valdymas</h2>
            <a href="{{ route('admin.librarian.create') }}" class="btn btn-primary">Sukurti bibliotekininką</a>
        </div>

        {{-- --------- SEARCH OPTION ------------------ --}}
        {{--
        <div style="margin: 1rem 0;">
            <form action="{{ route('admin.dashboard') }}" method="GET" style="display: flex; gap: 10px; width: 100%;">
                <input
                    type="text"
                    name="search"
                    class="form-control"
                    placeholder="Ieškoti pagal vardą, pavardę ar el. paštą..."
                    value="{{ request('search') }}"
                    style="flex: 1;"
                >
                <button type="submit" class="btn btn-secondary">Ieškoti</button>
                @if(request('search'))
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">Išvalyti</a>
                @endif
            </form>
        </div>
        --}}
        {{-- --------- SEARCH OPTION ------------------ --}}

        @if($librarians->isEmpty())
            <p>Šiuo metu nėra sukurtų bibliotekininkų.</p>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Vardas</th>
                        <th>Pavardė</th>
                        <th>El. paštas</th>
                        <th>Sukurta</th>
                        <th>Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($librarians as $librarian)
                        <tr>
                            <td>{{ $librarian->name }}</td>
                            <td>{{ $librarian->surname }}</td>
                            <td>{{ $librarian->email }}</td>
                            <td>{{ $librarian->created_at->format('Y-m-d') }}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-danger btn-sm"
                                        onclick="openDeleteModal('{{ route('admin.librarian.destroy', $librarian) }}')">
                                    Panaikinti
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div id="customDeleteModal" class="custom-modal-overlay">
        <div class="custom-modal-box">
            <h4>Patvirtinimas</h4>
            <p style="margin-top: 15px;">Ar tikrai norite panaikinti šį bibliotekininką?</p>

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
