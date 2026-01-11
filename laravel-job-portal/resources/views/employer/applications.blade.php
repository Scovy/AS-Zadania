@extends('layouts.app')

@section('title', $jobOffer ? 'Aplikacje - ' . $jobOffer->tytul : 'Wszystkie aplikacje - IT Job Portal')

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('employer.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="mb-4">
                <a href="{{ route('employer.offers') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Wróć do ofert
                </a>
            </div>

            @if($jobOffer)
                <h2 class="mb-2">Aplikacje na ofertę</h2>
                <p class="text-muted mb-4">{{ $jobOffer->tytul }}</p>
            @else
                <h2 class="mb-4">Wszystkie otrzymane aplikacje</h2>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    @if(!$jobOffer)
                                        <th>Oferta</th>
                                    @endif
                                    <th>Kandydat</th>
                                    <th>Email</th>
                                    <th>Telefon</th>
                                    <th>CV</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                    <tr>
                                        @if(!$jobOffer)
                                            <td>
                                                <a href="{{ route('job-offer.show', $application->jobOffer) }}" class="text-decoration-none fw-bold">
                                                    {{ Str::limit($application->jobOffer->tytul, 30) }}
                                                </a>
                                            </td>
                                        @endif
                                        <td>
                                            <strong>{{ $application->user->candidateProfile?->full_name ?: $application->user->name }}</strong>
                                            @if($application->wiadomosc)
                                                <br>
                                                <small class="text-muted">{{ Str::limit($application->wiadomosc, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $application->user->email }}</td>
                                        <td>{{ $application->user->candidateProfile?->telefon ?? '-' }}</td>
                                        <td>
                                            @if($application->user->candidateProfile?->cv_path)
                                                <a href="{{ Storage::url($application->user->candidateProfile->cv_path) }}" 
                                                   target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-pdf"></i> CV
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <form action="{{ route('employer.applications.status', $application) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <select name="status_id" class="form-select form-select-sm" 
                                                        onchange="this.form.submit()" style="width: auto;">
                                                    @foreach($statuses as $status)
                                                        <option value="{{ $status->id }}" {{ $application->status_id == $status->id ? 'selected' : '' }}>
                                                            {{ $status->nazwa }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $jobOffer ? 6 : 7 }}" class="text-center py-4 text-muted">
                                            Brak aplikacji.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                {{ $applications->links() }}
            </div>
        </main>
    </div>
</div>
@endsection
