@extends('layouts.app')
@section('title', 'Bibliotekininko Skydelis')
@section('content')
    <div class="card">
        <h2 style="margin-bottom: 2rem;">Bibliotekininko Skydelis</h2>
        <div class="grid">
            <div class="card">
                <h3>Greitieji Veiksmai</h3>
                <div style="margin-top: 1rem;">
                    <a href="{{ route('books.index') }}" class="btn btn-primary">Knygų Valdymas</a>
                    <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Rezervacijų Valdymas</a>
                </div>
            </div>
        </div>
    </div>
@endsection
