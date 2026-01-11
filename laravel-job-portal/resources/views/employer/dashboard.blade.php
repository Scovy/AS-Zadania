@extends('layouts.app')

@section('title', 'Panel Pracodawcy - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('employer.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Panel Pracodawcy</h2>

            @if(!$company)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Uzupełnij profil firmy</strong> aby móc publikować oferty pracy.
                    <a href="{{ route('employer.profile') }}" class="btn btn-sm btn-warning ms-3">Uzupełnij profil</a>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Wszystkie oferty</h6>
                            <h3>{{ $stats['total_offers'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Aktywne oferty</h6>
                            <h3>{{ $stats['active_offers'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Wszystkie aplikacje</h6>
                            <h3>{{ $stats['total_applications'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Nowe aplikacje</h6>
                            <h3 class="text-primary">{{ $stats['new_applications'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ostatnie aplikacje</h5>
                </div>
                <div class="card-body">
                    @forelse($recentApplications as $application)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $application->user->candidateProfile?->full_name ?: $application->user->name }}</strong>
                                <br>
                                <small class="text-muted">na: {{ $application->jobOffer->tytul }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $application->status_id == 1 ? 'secondary' : ($application->status_id == 3 ? 'success' : ($application->status_id == 4 ? 'danger' : 'info')) }}">
                                    {{ $application->status->nazwa }}
                                </span>
                                <br>
                                <small class="text-muted">{{ $application->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Brak aplikacji.</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
