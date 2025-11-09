@extends('layouts.app')

@section('title', 'Admino Skydelis')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2>Bibliotekininkų Valdymas</h2>
            <a href="{{ route('admin.librarian.create') }}" class="btn btn-primary">Sukurti bibliotekininką</a>
        </div>

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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($librarians as $librarian)
                        <tr>
                            <td>{{ $librarian->name }}</td>
                            <td>{{$librarian->surname}}</td>
                            <td>{{ $librarian->email }}</td>
                            <td>{{ $librarian->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
