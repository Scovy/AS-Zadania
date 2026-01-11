@extends('layouts.app')

@section('title', 'Panel Kandydata - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('candidate.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Witaj, {{ auth()->user()->name }}!</h2>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Złożone aplikacje</h6>
                            <h3>{{ auth()->user()->applications()->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">W trakcie</h6>
                            <h3>{{ auth()->user()->applications()->where('status_id', 2)->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Zaakceptowane</h6>
                            <h3>{{ auth()->user()->applications()->where('status_id', 3)->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ostatnie aplikacje</h5>
                </div>
                <div class="card-body">
                    @forelse($applications as $application)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $application->jobOffer->tytul }}</strong>
                                <br>
                                <small class="text-muted">{{ $application->jobOffer->companyProfile->nazwa_firmy }}</small>
                            </div>
                            <span class="badge bg-{{ $application->status_id == 1 ? 'secondary' : ($application->status_id == 3 ? 'success' : ($application->status_id == 4 ? 'danger' : 'info')) }}">
                                {{ $application->status->nazwa }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Nie masz jeszcze żadnych aplikacji.</p>
                    @endforelse

                    @if($applications->count() > 0)
                        <a href="{{ route('candidate.applications') }}" class="btn btn-outline-primary mt-3">
                            Zobacz wszystkie
                        </a>
                    @endif
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
