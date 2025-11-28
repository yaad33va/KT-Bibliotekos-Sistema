@extends('layouts.app')
@section('title', 'Knygų Sąrašas')
@section('content')
    <div class="card">
        <!-- Flex layout with three columns: left spacer, centered title, right actions -->
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

        @if($books->isEmpty())
            <p>Knygų katalogas tuščias.</p>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Pavadinimas</th>
                        <th>Autorius</th>
                        <th>Žanras</th>
                        <th>Leidimo Data</th>
                        <th>Laisvas Kiekis</th>
                        <th>Aprašymas</th>
                        @auth
                            @if(auth()->user()->hasRole('librarian'))
                                <th>Veiksmai</th>
                            @endif
                        @endauth
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->genre }}</td>
                            <td>{{ $book->release_date->format('Y-m-d') }}</td>
                            <td>{{ $book->book_count }}</td>
                            <td>{{ $book->book_description }}</td>
                            @auth
                                @if(auth()->user()->hasRole('librarian'))
                                    <td style="display: flex; gap: 0.5rem">
                                        <a href="{{ route('books.edit', $book) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem;">Redaguoti</a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti šią knygą?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem;">Ištrinti</button>
                                        </form>
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
@endsection
