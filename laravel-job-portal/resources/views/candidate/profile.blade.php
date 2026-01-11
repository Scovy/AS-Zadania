@extends('layouts.app')

@section('title', 'Mój Profil - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('candidate.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Mój profil</h2>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('candidate.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="imie" class="form-label">Imię *</label>
                                <input type="text" class="form-control @error('imie') is-invalid @enderror" 
                                       id="imie" name="imie" value="{{ old('imie', $profile->imie) }}" required>
                                @error('imie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nazwisko" class="form-label">Nazwisko *</label>
                                <input type="text" class="form-control @error('nazwisko') is-invalid @enderror" 
                                       id="nazwisko" name="nazwisko" value="{{ old('nazwisko', $profile->nazwisko) }}" required>
                                @error('nazwisko')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="telefon" class="form-label">Telefon</label>
                            <input type="text" class="form-control @error('telefon') is-invalid @enderror" 
                                   id="telefon" name="telefon" value="{{ old('telefon', $profile->telefon) }}">
                            @error('telefon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="o_mnie" class="form-label">O mnie</label>
                            <textarea class="form-control @error('o_mnie') is-invalid @enderror" 
                                      id="o_mnie" name="o_mnie" rows="5">{{ old('o_mnie', $profile->o_mnie) }}</textarea>
                            @error('o_mnie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="cv" class="form-label">CV (PDF, max 5MB)</label>
                            @if($profile->cv_path)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($profile->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-pdf me-1"></i>Zobacz aktualne CV
                                    </a>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('cv') is-invalid @enderror" 
                                   id="cv" name="cv" accept=".pdf">
                            @error('cv')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Zapisz zmiany
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
