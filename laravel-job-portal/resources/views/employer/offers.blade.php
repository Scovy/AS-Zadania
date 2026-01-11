@extends('layouts.app')

@section('title', 'Moje oferty - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('employer.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Moje oferty</h2>
                <a href="{{ route('employer.offers.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Dodaj ofertę
                </a>
            </div>

            @if(!$company)
                <div class="alert alert-warning">
                    Najpierw <a href="{{ route('employer.profile') }}">uzupełnij profil firmy</a>.
                </div>
            @else
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tytuł</th>
                                        <th>Kategoria</th>
                                        <th>Aplikacje</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Akcje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($offers as $offer)
                                        <tr>
                                            <td>
                                                <strong>{{ $offer->tytul }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $offer->lokalizacja }}</small>
                                            </td>
                                            <td>{{ $offer->category->nazwa }}</td>
                                            <td>
                                                <a href="{{ route('employer.applications', $offer) }}" class="badge bg-info text-decoration-none">
                                                    {{ $offer->applications_count }} aplikacji
                                                </a>
                                            </td>
                                            <td>
                                                @if($offer->aktywna)
                                                    <span class="badge bg-success">Aktywna</span>
                                                @else
                                                    <span class="badge bg-secondary">Nieaktywna</span>
                                                @endif
                                            </td>
                                            <td>{{ $offer->created_at->format('d.m.Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('employer.applications', $offer) }}" class="btn btn-outline-info" title="Zobacz aplikacje">
                                                        <i class="bi bi-people"></i>
                                                    </a>
                                                    <a href="{{ route('job-offer.show', $offer) }}" class="btn btn-outline-secondary" title="Podgląd">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('employer.offers.edit', $offer) }}" class="btn btn-outline-primary" title="Edytuj">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('employer.offers.delete', $offer) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('Czy na pewno chcesz usunąć tę ofertę?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger rounded-0 rounded-end" title="Usuń" style="border-left: none; margin-left: -1px;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">
                                                Nie masz jeszcze żadnych ofert.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if(is_object($offers) && method_exists($offers, 'links'))
                    <div class="mt-3">{{ $offers->links() }}</div>
                @endif
            @endif
        </main>
    </div>
</div>
@endsection
