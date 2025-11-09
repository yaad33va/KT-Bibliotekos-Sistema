@extends('layouts.app')
@section('title', 'Redaguoti Knygą')
@section('content')
    <div class="card" style="max-width: 600px; margin: 2rem auto;">
        <h2 style="text-align: center; margin-bottom: 1.5rem;">Redaguoti knygą: {{ $book->title }}</h2>
        <form method="POST" action="{{ route('books.update', $book) }}">
            @csrf
            @method('PUT')
            <div class="form-group"><label for="title">Pavadinimas</label><input id="title" type="text" name="title" value="{{ old('title', $book->title) }}" required></div>
            <div class="form-group"><label for="author">Autorius</label><input id="author" type="text" name="author" value="{{ old('author', $book->author) }}" required></div>
            <div class="form-group"><label for="genre">Žanras</label><input id="genre" type="text" name="genre" value="{{ old('genre', $book->genre) }}" required></div>
            <div class="form-group"><label for="release_date">Leidimo data</label><input id="release_date" type="date" name="release_date" value="{{ old('release_date', $book->release_date->format('Y-m-d')) }}" required></div>
            <div class="form-group"><label for="page_count">Puslapių skaičius</label><input id="page_count" type="number" name="page_count" value="{{ old('page_count', $book->page_count) }}" required min="1"></div>
            <div class="form-group"><label for="book_count">Kiekis (kopijų skaičius)</label><input id="book_count" type="number" name="book_count" value="{{ old('book_count', $book->book_count) }}" required min="0"></div>
            <div class="form-group"><label for="book_description">Aprašymas</label><textarea id="book_description" name="book_description" rows="5" required>{{ old('book_description', $book->book_description) }}</textarea></div>
            <div style="display: flex; justify-content: flex-end; margin-top: 1.5rem;"><a href="{{ route('books.index') }}" class="btn btn-secondary" style="margin-right: 1rem;">Atšaukti</a><button type="submit" class="btn btn-primary">Atnaujinti</button></div>
        </form>
    </div>
@endsection
