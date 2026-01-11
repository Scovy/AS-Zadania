@extends('layouts.app')

@section('title', 'Tagi - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Zarządzanie tagami technologii</h2>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Dodaj nowy tag</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.tags.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nazwa" class="form-label">Nazwa tagu</label>
                                    <input type="text" class="form-control @error('nazwa') is-invalid @enderror" 
                                           id="nazwa" name="nazwa" value="{{ old('nazwa') }}" required>
                                    @error('nazwa')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-plus me-1"></i>Dodaj tag
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Lista tagów</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nazwa</th>
                                            <th>Akcje</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tags as $tag)
                                            <tr>
                                                <td>{{ $tag->id }}</td>
                                                <td>
                                                    <form action="{{ route('admin.tags.update', $tag) }}" method="POST" class="d-flex gap-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="text" class="form-control form-control-sm" 
                                                               name="nazwa" value="{{ $tag->nazwa }}" style="max-width: 200px;">
                                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-check"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form action="{{ route('admin.tags.delete', $tag) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('Czy na pewno chcesz usunąć ten tag?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        {{ $tags->links() }}
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
