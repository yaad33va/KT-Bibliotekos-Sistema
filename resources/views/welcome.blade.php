@extends('layouts.app')

@section('title', 'Sveiki atvykę į Biblioteką!')

@section('content')
    <style>
        /* Jumbotron stilius */
        .jumbotron {
            background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da?fit=crop&w=1200&h=600&q=80') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 6rem 2rem;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .jumbotron::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            /* PAKEISTA: Nuimta žalia spalva, paliktas tik neutralus tamsinimas, kad tekstas būtų baltas ir įskaitomas */
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .jumbotron-content {
            position: relative;
            z-index: 2;
        }

        .jumbotron h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }

        .jumbotron p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
        }

        /* Mygtukų stilius Jumbotron'e */
        .jumbotron .btn {
            margin: 0.5rem;
            border-width: 0;
            font-weight: 700;
            padding: 1rem 2rem; /* Didesni mygtukai */
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Priminimų kortelės stilius */
        .reminder-card {
            border: none;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(42, 157, 143, 0.15);
            border-radius: 12px;
        }

        /* STILIZUOTAS PRIMINIMŲ HEADERIS - ŽALIAS */
        .reminder-header-styled {
            background: linear-gradient(135deg, #2a9d8f 0%, #218276 100%);
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            position: relative;
        }

        .reminder-header-styled::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0; height: 4px;
            background: rgba(255,255,255,0.2);
        }

        .reminder-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.6rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .reminder-card .list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: none;
            border-bottom: 1px solid #f0f0f0;
            padding: 1.2rem 1.5rem;
            transition: background-color 0.2s;
            border-left: 4px solid transparent;
        }

        .reminder-card .list-group-item:hover {
            background-color: #f1fcfb;
            border-left: 4px solid #2a9d8f;
        }

        .reminder-meta {
            text-align: right;
            min-width: 160px;
        }

        .reminder-small {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
        }

        .alert-info-custom {
            background-color: #e6fffa;
            color: #234e52;
            padding: 15px;
            font-size: 1rem;
            border-bottom: 1px solid #b2f5ea;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .book-title {
            font-size: 1.15rem;
            color: #264653;
            font-weight: 700;
        }

        .due-date {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2a9d8f;
        }

        .due-date.urgent {
            color: #e76f51;
        }
    </style>

    <div class="jumbotron">
        <div class="jumbotron-content">
            <h1>Sveiki atvykę į Bibliotekos Sistemą</h1>
            <p>Darbo autorė: Denisa Valinčiūtė, IFF-3/2</p>
            <div style="margin-top: 2rem;">
                @auth
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg shadow">Eiti į Admino Skydelį</a>
                    @elseif(auth()->user()->hasRole('librarian'))
                        <a href="{{ route('librarian.dashboard') }}" class="btn btn-primary btn-lg shadow">Eiti į Skydelį</a>
                    @else
                        {{-- PAKEISTA: Naudojama btn-primary klasė (matomas fonas), tekstas baltas --}}
                        <a href="{{ route('books.index') }}" class="btn btn-primary btn-lg shadow">
                            <i class="fas fa-book"></i> Peržiūrėti knygas
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg shadow me-2">Prisijungti</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">Registruotis</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="container">
        @auth
            @if(auth()->user()->hasRole('user') && isset($dueReservations) && $dueReservations->isNotEmpty())
                <div class="card reminder-card">

                    {{-- Stilingas Žalias Headeris --}}
                    <div class="reminder-header-styled">
                        <div class="reminder-title">
                            <i class="fas fa-bell"></i>
                            PRIMINIMAI
                        </div>
                    </div>

                    {{-- Informacinė juostelė --}}
                    <div class="alert-info-custom text-center">
                        <i class="fas fa-clock" style="color: #2a9d8f;"></i>
                        <span>Knygos, kurias turite grąžinti per artimiausias <strong>{{ $daysWindow }} d.</strong></span>
                    </div>

                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($dueReservations as $res)
                                <li class="list-group-item">
                                    <div>
                                        <div class="book-title">
                                            {{ optional($res->book)->title ?? 'Nežinoma knyga' }}
                                        </div>
                                        <div class="mt-1 text-muted" style="font-size: 0.9rem;">
                                            <i class="far fa-calendar-check" style="color: #2a9d8f;"></i>
                                            Rezervuota: {{ optional($res->reservation_date)->format('Y-m-d H:i') ?? '-' }}
                                        </div>
                                    </div>

                                    <div class="reminder-meta">
                                        <div class="reminder-small">Grąžinti iki</div>

                                        @php
                                            $isUrgent = optional($res->return_date)->isPast() || optional($res->return_date)->diffInDays(now()) < 2;
                                        @endphp

                                        <div class="due-date {{ $isUrgent ? 'urgent' : '' }}">
                                            {{ optional($res->return_date)->format('Y-m-d') }}
                                            <span style="font-size: 0.8rem; opacity: 0.8;">{{ optional($res->return_date)->format('H:i') }}</span>
                                        </div>

                                        @if(optional($res->return_date)->isPast())
                                            <span class="badge bg-danger mt-1">Pradelsta</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="p-3 text-center bg-light border-top">
                            <a href="{{ route('reservations.index') }}" class="btn btn-sm btn-outline-secondary" style="color: #264653; border-color: #264653;">
                                Peržiūrėti visas rezervacijas <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
@endsection
