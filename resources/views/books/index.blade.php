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
            <p class="text-center text-muted my-5">Knygų katalogas tuščias.</p>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Pavadinimas</th>
                        <th>Autorius</th>
                        <th>Žanras</th>
                        {{-- Pakeitimas: Pridėta white-space: nowrap, kad antraštė nelūžtų --}}
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

                            {{-- Pakeitimas: Pridėta white-space: nowrap, kad data visada būtų vienoje eilutėje --}}
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
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti šią knygą?');" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" style="font-size: 0.8rem;">Ištrinti</button>
                                            </form>
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
@endsection
