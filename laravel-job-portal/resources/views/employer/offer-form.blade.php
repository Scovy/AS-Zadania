@extends('layouts.app')

@section('title', ($offer ? 'Edytuj' : 'Nowa') . ' oferta - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('employer.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">{{ $offer ? 'Edytuj ofertę' : 'Nowa oferta pracy' }}</h2>

            <div class="card">
                <div class="card-body">
                    <form action="{{ $offer ? route('employer.offers.update', $offer) : route('employer.offers.store') }}" method="POST">
                        @csrf
                        @if($offer)
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label for="tytul" class="form-label">Tytuł stanowiska *</label>
                            <input type="text" class="form-control @error('tytul') is-invalid @enderror" 
                                   id="tytul" name="tytul" value="{{ old('tytul', $offer?->tytul) }}" required>
                            @error('tytul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Kategoria *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">Wybierz kategorię</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $offer?->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nazwa }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lokalizacja" class="form-label">Lokalizacja *</label>
                                <input type="text" class="form-control @error('lokalizacja') is-invalid @enderror" 
                                       id="lokalizacja" name="lokalizacja" value="{{ old('lokalizacja', $offer?->lokalizacja) }}" required>
                                @error('lokalizacja')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="typ_pracy" class="form-label">Tryb pracy *</label>
                                <select class="form-select @error('typ_pracy') is-invalid @enderror" id="typ_pracy" name="typ_pracy" required>
                                    <option value="office" {{ old('typ_pracy', $offer?->typ_pracy) == 'office' ? 'selected' : '' }}>Stacjonarnie</option>
                                    <option value="hybrid" {{ old('typ_pracy', $offer?->typ_pracy) == 'hybrid' ? 'selected' : '' }}>Hybrydowo</option>
                                    <option value="remote" {{ old('typ_pracy', $offer?->typ_pracy) == 'remote' ? 'selected' : '' }}>Zdalnie</option>
                                </select>
                                @error('typ_pracy')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="wynagrodzenie_min" class="form-label">Wynagrodzenie od (PLN)</label>
                                <input type="number" class="form-control @error('wynagrodzenie_min') is-invalid @enderror" 
                                       id="wynagrodzenie_min" name="wynagrodzenie_min" value="{{ old('wynagrodzenie_min', $offer?->wynagrodzenie_min) }}">
                                @error('wynagrodzenie_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="wynagrodzenie_max" class="form-label">Wynagrodzenie do (PLN)</label>
                                <input type="number" class="form-control @error('wynagrodzenie_max') is-invalid @enderror" 
                                       id="wynagrodzenie_max" name="wynagrodzenie_max" value="{{ old('wynagrodzenie_max', $offer?->wynagrodzenie_max) }}">
                                @error('wynagrodzenie_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="wazna_do" class="form-label">Oferta ważna do</label>
                            <input type="date" class="form-control @error('wazna_do') is-invalid @enderror" 
                                   id="wazna_do" name="wazna_do" value="{{ old('wazna_do', $offer?->wazna_do?->format('Y-m-d')) }}">
                            @error('wazna_do')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Technologie</label>
                            <div class="row">
                                @foreach($tags as $tag)
                                    <div class="col-md-3 col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="tags[]" 
                                                   value="{{ $tag->id }}" id="tag{{ $tag->id }}"
                                                   {{ in_array($tag->id, old('tags', $offer?->tags->pluck('id')->toArray() ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                                {{ $tag->nazwa }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="opis" class="form-label">Opis stanowiska *</label>
                            <textarea class="form-control @error('opis') is-invalid @enderror" 
                                      id="opis" name="opis" rows="10" required>{{ old('opis', $offer?->opis) }}</textarea>
                            @error('opis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($offer)
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="aktywna" id="aktywna" value="1"
                                           {{ old('aktywna', $offer->aktywna) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="aktywna">
                                        Oferta aktywna
                                    </label>
                                </div>
                            </div>
                        @endif

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>{{ $offer ? 'Zapisz zmiany' : 'Opublikuj ofertę' }}
                            </button>
                            <a href="{{ route('employer.offers') }}" class="btn btn-outline-secondary">Anuluj</a>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
