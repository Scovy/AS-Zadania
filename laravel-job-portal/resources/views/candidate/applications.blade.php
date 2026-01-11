@extends('layouts.app')

@section('title', 'Moje aplikacje - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('candidate.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Moje aplikacje</h2>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Stanowisko</th>
                                    <th>Firma</th>
                                    <th>Kategoria</th>
                                    <th>Data aplikacji</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                    <tr>
                                        <td>
                                            <a href="{{ route('job-offer.show', $application->jobOffer) }}">
                                                {{ $application->jobOffer->tytul }}
                                            </a>
                                        </td>
                                        <td>{{ $application->jobOffer->companyProfile->nazwa_firmy }}</td>
                                        <td>{{ $application->jobOffer->category->nazwa }}</td>
                                        <td>{{ $application->created_at->format('d.m.Y H:i') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $application->status_id == 1 ? 'secondary' : ($application->status_id == 3 ? 'success' : ($application->status_id == 4 ? 'danger' : 'info')) }}">
                                                {{ $application->status->nazwa }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">
                                            Nie masz jeszcze żadnych aplikacji.
                                            <br>
                                            <a href="{{ route('home') }}" class="btn btn-primary mt-2">Przeglądaj oferty</a>
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
