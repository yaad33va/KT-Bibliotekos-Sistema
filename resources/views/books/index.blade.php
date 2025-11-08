@extends('layouts.app')

@section('title', 'Knygų Sąrašas')

@section('content')
    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2>Visos Knygos</h2>
            {{-- You could add a filter/search form here in the future --}}
        </div>

        @if($books->isEmpty())
            <p>Šiuo metu bibliotekoje knygų nėra.</p>
        @else
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                    <tr>
                        <th>Viršelis</th>
                        <th>Pavadinimas</th>
                        <th>Autorius</th>
                        <th>Leidimo metai</th>
                        <th>Būsena</th>
                        @auth
                            <th>Veiksmai</th>
                        @endauth
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($books as $book)
                        <tr>
                            <td>
                                {{-- Assuming you have an 'cover_image_url' attribute on your book model --}}
                                @if($book->cover_image_url)
                                    <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" style="width: 50px; height: auto; border-radius: 4px;">
                                @else
                                    <div style="width: 50px; height: 70px; background: #eee; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                        📚
                                    </div>
                                @endif
                            </td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->published_year }}</td>
                            <td>
                                {{--
                                  This assumes you have a way to check if a book is borrowed.
                                  For example, an 'is_borrowed' attribute or a check on its relationships.
                                --}}
                                @if($book->is_borrowed)
                                    <span style="color: #dc3545; font-weight: 500;">Paskolinta</span>
                                @else
                                    <span style="color: #28a745; font-weight: 500;">Laisva</span>
                                @endif
                            </td>
                            @auth
                                <td>
                                    {{-- Only show borrow button if the book is available --}}
                                    @if(!$book->is_borrowed)
                                        <form action="{{ route('borrows.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="btn btn-success" style="padding: 0.5rem 1rem;">Skolintis</button>
                                        </form>
                                    @else
                                        {{-- Optional: Show a disabled button or nothing --}}
                                        <button class="btn btn-secondary" style="padding: 0.5rem 1rem;" disabled>Paskolinta</button>
                                    @endif
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination links --}}
            <div style="margin-top: 2rem;">
                {{ $books->links() }}
            </div>
        @endif
    </div>
@endsection
