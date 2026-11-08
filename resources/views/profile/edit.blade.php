@extends('adminlte::page')

@section('title', 'Profil Pengguna')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0 text-dark font-weight-bold">Pengaturan Akun & Profil</h1>
            <p class="text-muted m-0 small">Kelola informasi kredensial login dan kata sandi akun Anda</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
    </div>
@stop

@section('content')
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Informasi profil berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Kata sandi akun berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        {{-- Profile Summary Card --}}
        <div class="col-lg-4">
            <div class="card card-outline card-primary shadow-sm text-center mb-4">
                <div class="card-body">
                    <img src="{{ auth()->user()->adminlte_image() }}" alt="Avatar" class="rounded-circle shadow-sm mb-3" width="90" height="90">
                    <h4 class="fw-bold mb-1">{{ auth()->user()->name }}</h4>
                    <p class="text-muted small mb-2">{{ auth()->user()->email }}</p>
                    <div>
                        @foreach(auth()->user()->roles as $role)
                            <span class="badge {{ $role->name === 'Admin' ? 'bg-danger' : 'bg-info text-white' }} px-3 py-1.5 fs-6">
                                Role: {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Updates --}}
        <div class="col-lg-8">
            {{-- Update Profile Info --}}
            <div class="card card-outline card-primary shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-bold text-dark mb-0">Informasi Pribadi</h5>
                </div>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Alamat Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Profil
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="card card-outline card-warning shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title fw-bold text-dark mb-0">Perbarui Kata Sandi</h5>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">Kata Sandi Saat Ini</label>
                            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                id="current_password" name="current_password" autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Kata Sandi Baru</label>
                            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                id="password" name="password" autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning text-dark fw-bold">
                            <i class="bi bi-key-fill me-1"></i> Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
