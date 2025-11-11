@extends('layouts.app')
@section('title', 'Bibliotekininko Skydelis')
@section('content')
    <div class="card">
        <center><h2 style="margin-bottom: 2rem;">Bibliotekininko veiksmai</h2></center>
            <div style="margin-top: 1rem;">
                <a href="{{ route('books.index') }}" class="btn btn-primary">Knygų valdymas</a>
                <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Rezervacijų valdymas</a>
            </div>
    </div>
@endsection
