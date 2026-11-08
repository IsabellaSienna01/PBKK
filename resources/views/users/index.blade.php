@extends('adminlte::page')

@section('title', 'Manajemen Pengguna & RBAC')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold">Manajemen Pengguna & Otorisasi RBAC</h1>
            <p class="text-muted m-0 small">Pengaturan peran dinamis Spatie (Admin & Staf)</p>
        </div>
        <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna Baru
        </button>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Callout Penjelasan RBAC --}}
    <div class="callout callout-warning shadow-sm mb-4">
        <h5 class="fw-bold mb-1"><i class="bi bi-shield-lock-fill text-warning"></i> Aturan Hak Akses Berbasis Peran (RBAC)</h5>
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="p-2 border rounded">
                    <span class="badge bg-danger">Role: Admin</span>
                    <p class="small text-muted mb-0 mt-1">
                        Memiliki akses menyeluruh ke seluruh modul, termasuk <strong>Hak Eksklusif Hapus Data</strong> dan pengelolaan pengguna & peran.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-2 border rounded">
                    <span class="badge bg-info text-white">Role: Staf</span>
                    <p class="small text-muted mb-0 mt-1">
                        Memiliki akses terbatas untuk melihat, menambah, dan mengubah data. <strong>Tidak memiliki izin menghapus data</strong> (tombol hapus dikunci dan controller menolak akses).
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Pengguna --}}
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title fw-bold mb-0">
                <i class="bi bi-people-fill me-1"></i> Daftar Akun Pengguna & Peran
            </h3>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Nama Pengguna</th>
                        <th>Email Login</th>
                        <th>Peran (Spatie Role)</th>
                        <th>Cakupan Hak Akses (Permissions)</th>
                        <th style="width: 220px;" class="text-center">Ubah Peran / Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $u)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $u->adminlte_image() }}" alt="Avatar" class="rounded-circle" width="36" height="36">
                                    <div>
                                        <div class="fw-bold">{{ $u->name }}</div>
                                        @if($u->id === auth()->id())
                                            <span class="badge bg-secondary small">Akun Anda Saat Ini</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $u->email }}</code></td>
                            <td>
                                @foreach($u->roles as $r)
                                    <span class="badge {{ $r->name === 'Admin' ? 'bg-danger' : 'bg-info text-white' }} px-2 py-1 fs-6">
                                        {{ $r->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <div class="small text-muted" style="max-width: 320px;">
                                    @if($u->hasRole('Admin'))
                                        <span class="text-success fw-bold"><i class="bi bi-check-all"></i> Akses Penuh (All Permissions)</span>
                                    @else
                                        <span class="text-secondary"><i class="bi bi-check2"></i> View, Create, Edit (Tanpa Hapus Data)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    {{-- Form Ganti Role --}}
                                    <form method="POST" action="{{ route('dashboard.users.role', $u) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        @if($u->hasRole('Admin'))
                                            <input type="hidden" name="role" value="Staf">
                                            <button type="submit" class="btn btn-xs btn-outline-info" title="Ubah menjadi Staf"
                                                {{ $u->id === auth()->id() ? 'disabled' : '' }}>
                                                Jadikan Staf
                                            </button>
                                        @else
                                            <input type="hidden" name="role" value="Admin">
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Promosikan ke Admin">
                                                Jadikan Admin
                                            </button>
                                        @endif
                                    </form>

                                    {{-- Hapus Pengguna --}}
                                    @if($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('dashboard.users.destroy', $u) }}" class="d-inline"
                                            onsubmit="return confirm('Hapus akun {{ $u->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus Akun">
                                                <i class="bi bi-trash-fill"></i>
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

        <div class="card-footer d-flex justify-content-end">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- Modal Tambah Pengguna Baru --}}
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addUserModalLabel">
                        <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna & Tetapkan Peran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('dashboard.users.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Contoh: Staff Akademik Baru">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Login</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="staff.baru@academic.its.ac.id">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Minimal 8 karakter">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label fw-semibold">Peran (Spatie Role)</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="Staf">Staf (Akses Terbatas - Tanpa Izin Hapus)</option>
                                <option value="Admin">Admin (Akses Penuh - Termasuk Hapus Data)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Pengguna
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
