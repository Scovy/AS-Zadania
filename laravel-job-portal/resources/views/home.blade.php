@extends('layouts.app')

@section('title', 'Oferty pracy IT - IT Job Portal')

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="filter-section">
                <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Filtry</h5>
                
                <form action="{{ route('home') }}" method="GET">
                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Szukaj</label>
                        <input type="text" class="form-control" name="search" 
                               value="{{ request('search') }}" placeholder="Tytuł stanowiska...">
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kategoria</label>
                        <select class="form-select" name="category">
                            <option value="">Wszystkie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nazwa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Lokalizacja</label>
                        <input type="text" class="form-control" name="location" 
                               value="{{ request('location') }}" placeholder="np. Warszawa">
                    </div>

                    <!-- Work Type -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tryb pracy</label>
                        <select class="form-select" name="work_type">
                            <option value="">Wszystkie</option>
                            <option value="remote" {{ request('work_type') == 'remote' ? 'selected' : '' }}>Zdalnie</option>
                            <option value="hybrid" {{ request('work_type') == 'hybrid' ? 'selected' : '' }}>Hybrydowo</option>
                            <option value="office" {{ request('work_type') == 'office' ? 'selected' : '' }}>Stacjonarnie</option>
                        </select>
                    </div>

                    <!-- Salary Range -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Wynagrodzenie (PLN)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" class="form-control" name="salary_min" 
                                       value="{{ request('salary_min') }}" placeholder="Od">
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" name="salary_max" 
                                       value="{{ request('salary_max') }}" placeholder="Do">
                            </div>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Technologie</label>
                        <div style="max-height: 200px; overflow-y: auto;">
                            @foreach($tags as $tag)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="tags[]" 
                                           value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                           {{ in_array($tag->id, (array)request('tags', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label small" for="tag{{ $tag->id }}">
                                        {{ $tag->nazwa }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Szukaj
                    </button>
                    
                    @if(request()->hasAny(['search', 'category', 'location', 'work_type', 'salary_min', 'salary_max', 'tags']))
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">
                            Wyczyść filtry
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Job Listings -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <i class="bi bi-briefcase me-2"></i>Oferty pracy
                    <span class="badge bg-secondary">{{ $jobOffers->total() }}</span>
                </h4>
            </div>

            @forelse($jobOffers as $offer)
                <div class="card job-card mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1">
                                    <a href="{{ route('job-offer.show', $offer) }}" class="text-decoration-none text-dark">
                                        {{ $offer->tytul }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-building me-1"></i>{{ $offer->companyProfile->nazwa_firmy }}
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-geo-alt me-1"></i>{{ $offer->lokalizacja }}
                                </p>
                                <div class="d-flex flex-wrap gap-1">
                                    <span class="badge work-type-badge">{{ $offer->getWorkTypeLabel() }}</span>
                                    <span class="badge bg-light text-dark">{{ $offer->category->nazwa }}</span>
                                    @foreach($offer->tags->take(4) as $tag)
                                        <span class="badge tag-badge">{{ $tag->nazwa }}</span>
                                    @endforeach
                                    @if($offer->tags->count() > 4)
                                        <span class="badge tag-badge">+{{ $offer->tags->count() - 4 }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <div class="mb-2">
                                    <span class="badge salary-badge fs-6">{{ $offer->salary_range }}</span>
                                </div>
                                <small class="text-muted">
                                    {{ $offer->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-search display-1 text-muted"></i>
                    <h5 class="mt-3">Nie znaleziono ofert</h5>
                    <p class="text-muted">Spróbuj zmienić kryteria wyszukiwania</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $jobOffers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
