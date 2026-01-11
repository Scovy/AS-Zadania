@extends('layouts.app')

@section('title', 'Panel Administratora - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Panel Administratora</h2>

            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Użytkownicy</h6>
                            <h3>{{ $stats['total_users'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Kandydaci</h6>
                            <h3>{{ $stats['candidates'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Pracodawcy</h6>
                            <h3>{{ $stats['employers'] }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <h6 class="text-muted">Tagi</h6>
                            <h3>{{ $stats['tags'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Szybkie akcje</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary me-2">
                                <i class="bi bi-people me-1"></i>Zarządzaj użytkownikami
                            </a>
                            <a href="{{ route('admin.tags') }}" class="btn btn-outline-primary">
                                <i class="bi bi-tags me-1"></i>Zarządzaj tagami
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
