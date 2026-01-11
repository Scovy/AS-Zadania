@extends('layouts.app')

@section('title', 'Profil Firmy - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('employer.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Profil firmy</h2>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('employer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nazwa_firmy" class="form-label">Nazwa firmy *</label>
                            <input type="text" class="form-control @error('nazwa_firmy') is-invalid @enderror" 
                                   id="nazwa_firmy" name="nazwa_firmy" value="{{ old('nazwa_firmy', $profile->nazwa_firmy) }}" required>
                            @error('nazwa_firmy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lokalizacja" class="form-label">Lokalizacja</label>
                                <input type="text" class="form-control @error('lokalizacja') is-invalid @enderror" 
                                       id="lokalizacja" name="lokalizacja" value="{{ old('lokalizacja', $profile->lokalizacja) }}">
                                @error('lokalizacja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="strona_www" class="form-label">Strona WWW</label>
                                <input type="url" class="form-control @error('strona_www') is-invalid @enderror" 
                                       id="strona_www" name="strona_www" value="{{ old('strona_www', $profile->strona_www) }}"
                                       placeholder="https://">
                                @error('strona_www')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="opis" class="form-label">Opis firmy</label>
                            <textarea class="form-control @error('opis') is-invalid @enderror" 
                                      id="opis" name="opis" rows="5">{{ old('opis', $profile->opis) }}</textarea>
                            @error('opis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="logo" class="form-label">Logo firmy (JPG/PNG, max 2MB)</label>
                            @if($profile->logo_path)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($profile->logo_path) }}" alt="Logo" style="max-height: 80px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept=".jpg,.jpeg,.png">
                            @error('logo')
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
