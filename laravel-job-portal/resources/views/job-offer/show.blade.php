@extends('layouts.app')

@section('title', $jobOffer->tytul . ' - IT Job Portal')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h2 class="mb-1">{{ $jobOffer->tytul }}</h2>
                            <p class="text-muted mb-0">
                                <i class="bi bi-building me-1"></i>{{ $jobOffer->companyProfile->nazwa_firmy }}
                            </p>
                        </div>
                        @if($jobOffer->companyProfile->logo_path)
                            <img src="{{ Storage::url($jobOffer->companyProfile->logo_path) }}" 
                                 alt="Logo" class="rounded" style="max-height: 60px;">
                        @endif
                    </div>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge salary-badge fs-6">{{ $jobOffer->salary_range }}</span>
                        <span class="badge work-type-badge">{{ $jobOffer->getWorkTypeLabel() }}</span>
                        <span class="badge bg-light text-dark">
                            <i class="bi bi-geo-alt me-1"></i>{{ $jobOffer->lokalizacja }}
                        </span>
                        <span class="badge bg-light text-dark">{{ $jobOffer->category->nazwa }}</span>
                    </div>

                    <h5>Technologie</h5>
                    <div class="d-flex flex-wrap gap-1 mb-4">
                        @foreach($jobOffer->tags as $tag)
                            <span class="badge tag-badge">{{ $tag->nazwa }}</span>
                        @endforeach
                    </div>

                    <h5>Opis stanowiska</h5>
                    <div class="mb-4" style="white-space: pre-line;">{{ $jobOffer->opis }}</div>

                    @if($jobOffer->wazna_do)
                        <p class="text-muted small">
                            <i class="bi bi-calendar me-1"></i>Oferta ważna do: {{ $jobOffer->wazna_do->format('d.m.Y') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Apply Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Aplikuj na to stanowisko</h5>
                    
                    @guest
                        <p class="text-muted">Zaloguj się jako kandydat, aby aplikować.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Zaloguj się</a>
                    @else
                        @if(auth()->user()->isCandidate())
                            @if($hasApplied)
                                <div class="alert alert-success mb-0">
                                    <i class="bi bi-check-circle me-2"></i>Już aplikowałeś na tę ofertę
                                </div>
                            @else
                                <form action="{{ route('candidate.apply', $jobOffer) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="wiadomosc" class="form-label">Wiadomość (opcjonalnie)</label>
                                        <textarea class="form-control" id="wiadomosc" name="wiadomosc" rows="4" 
                                                  placeholder="Napisz kilka słów o sobie..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="bi bi-send me-2"></i>Wyślij aplikację
                                    </button>
                                </form>
                            @endif
                        @else
                            <p class="text-muted mb-0">Tylko kandydaci mogą aplikować na oferty.</p>
                        @endif
                    @endguest
                </div>
            </div>

            <!-- Company Card -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">O firmie</h5>
                    <h6>{{ $jobOffer->companyProfile->nazwa_firmy }}</h6>
                    
                    @if($jobOffer->companyProfile->lokalizacja)
                        <p class="text-muted small mb-2">
                            <i class="bi bi-geo-alt me-1"></i>{{ $jobOffer->companyProfile->lokalizacja }}
                        </p>
                    @endif
                    
                    @if($jobOffer->companyProfile->opis)
                        <p class="small">{{ Str::limit($jobOffer->companyProfile->opis, 200) }}</p>
                    @endif
                    
                    @if($jobOffer->companyProfile->strona_www)
                        <a href="{{ $jobOffer->companyProfile->strona_www }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-globe me-1"></i>Strona firmy
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-3">
        <i class="bi bi-arrow-left me-1"></i>Wróć do listy ofert
    </a>
</div>
@endsection
