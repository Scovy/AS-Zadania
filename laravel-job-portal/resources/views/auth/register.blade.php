@extends('layouts.app')

@section('title', 'Rejestracja - IT Job Portal')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Rejestracja</h2>
                    
                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Typ konta</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="account_type" id="type_candidate" 
                                           value="kandydat" {{ old('account_type', 'kandydat') == 'kandydat' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary w-100 py-3" for="type_candidate">
                                        <i class="bi bi-person-fill d-block fs-4"></i>
                                        Szukam pracy
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="account_type" id="type_employer" 
                                           value="pracodawca" {{ old('account_type') == 'pracodawca' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary w-100 py-3" for="type_employer">
                                        <i class="bi bi-building d-block fs-4"></i>
                                        Szukam pracownika
                                    </label>
                                </div>
                            </div>
                            @error('account_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Imię i nazwisko</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="companyNameField" style="display: none;">
                            <label for="nazwa_firmy" class="form-label">Nazwa firmy</label>
                            <input type="text" class="form-control @error('nazwa_firmy') is-invalid @enderror" 
                                   id="nazwa_firmy" name="nazwa_firmy" value="{{ old('nazwa_firmy') }}">
                            @error('nazwa_firmy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Hasło</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 8 znaków</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Powtórz hasło</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">Zarejestruj się</button>
                    </form>

                    <hr class="my-4">
                    
                    <p class="text-center mb-0">
                        Masz już konto? <a href="{{ route('login') }}">Zaloguj się</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('input[name="account_type"]');
        const companyField = document.getElementById('companyNameField');
        
        function toggleCompanyField() {
            const selected = document.querySelector('input[name="account_type"]:checked');
            companyField.style.display = selected && selected.value === 'pracodawca' ? 'block' : 'none';
        }
        
        radios.forEach(radio => radio.addEventListener('change', toggleCompanyField));
        toggleCompanyField();
    });
</script>
@endpush
