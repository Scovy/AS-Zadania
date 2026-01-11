@extends('layouts.app')

@section('title', 'Użytkownicy - IT Job Portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.sidebar')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <h2 class="mb-4">Zarządzanie użytkownikami</h2>

            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('admin.users') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" placeholder="Szukaj po nazwie lub email...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="role">
                                <option value="">Wszystkie role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->nazwa }}" {{ request('role') == $role->nazwa ? 'selected' : '' }}>
                                        {{ ucfirst($role->nazwa) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Szukaj</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nazwa</th>
                                    <th>Email</th>
                                    <th>Rola</th>
                                    <th>Status</th>
                                    <th>Data rejestracji</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->role?->nazwa == 'admin' ? 'danger' : ($user->role?->nazwa == 'pracodawca' ? 'primary' : 'secondary') }}">
                                                {{ ucfirst($user->role?->nazwa ?? 'brak') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($user->aktywny)
                                                <span class="badge bg-success">Aktywny</span>
                                            @else
                                                <span class="badge bg-danger">Zablokowany</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary" title="Edytuj">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-{{ $user->aktywny ? 'warning' : 'success' }}" 
                                                                title="{{ $user->aktywny ? 'Zablokuj' : 'Odblokuj' }}">
                                                            <i class="bi bi-{{ $user->aktywny ? 'lock' : 'unlock' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Usuń">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </main>
    </div>
</div>
@endsection
