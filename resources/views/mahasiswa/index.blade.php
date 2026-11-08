@extends('adminlte::page')

@section('title', 'Data Mahasiswa')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold">Manajemen Data Mahasiswa</h1>
            <p class="text-muted m-0 small">Daftar mahasiswa terdaftar di portal akademik</p>
        </div>
        <div>
            @can('create-mahasiswa')
                <a href="{{ route('dashboard.mahasiswa.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Mahasiswa Baru
                </a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    {{-- Flash Notifications --}}
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

    {{-- Filter Pencarian & Kueri when() (Tantangan / Challenge Nilai Plus A+) --}}
    <div class="card card-outline card-primary shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title fw-bold mb-0">
                <i class="bi bi-search me-1"></i> Filter & Pencarian Data (Kueri <code>when()</code>)
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.mahasiswa.index') }}" class="row g-3">
                {{-- Input Kata Kunci --}}
                <div class="col-md-5">
                    <label for="search" class="form-label small fw-semibold text-secondary">Cari (Nama, NRP, atau Email)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Ketik kata kunci...">
                    </div>
                </div>

                {{-- Filter Jurusan --}}
                <div class="col-md-3">
                    <label for="jurusan" class="form-label small fw-semibold text-secondary">Program Studi / Jurusan</label>
                    <select class="form-select" id="jurusan" name="jurusan">
                        <option value="">Semua Program Studi</option>
                        @foreach($daftarJurusan as $j)
                            <option value="{{ $j }}" {{ request('jurusan') === $j ? 'selected' : '' }}>
                                {{ $j }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div class="col-md-2">
                    <label for="status" class="form-label small fw-semibold text-secondary">Status Akademik</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Cuti" {{ request('status') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Lulus" {{ request('status') === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                    </select>
                </div>

                {{-- Tombol Aksi Filter --}}
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'jurusan', 'status']))
                        <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data Mahasiswa --}}
    <div class="card card-outline card-secondary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="card-title fw-bold mb-0">
                    <i class="bi bi-table me-1"></i> Data Mahasiswa
                </h3>
                <span class="badge bg-secondary ms-2">{{ $mahasiswas->total() }} Data Total</span>
            </div>
            <div class="small text-muted">
                Menampilkan halaman <strong>{{ $mahasiswas->currentPage() }}</strong> dari <strong>{{ $mahasiswas->lastPage() }}</strong>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>NRP</th>
                        <th>Nama Lengkap</th>
                        <th>Email Kampus</th>
                        <th>Jurusan</th>
                        <th>Angkatan</th>
                        <th>IPK</th>
                        <th>Status</th>
                        <th style="width: 200px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $index => $mhs)
                        <tr>
                            <td>{{ $mahasiswas->firstItem() + $index }}</td>
                            <td>
                                <span class="font-monospace fw-bold text-primary">{{ $mhs->nrp }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $mhs->nama }}</div>
                            </td>
                            <td>
                                <span class="small text-muted">{{ $mhs->email }}</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $mhs->jurusan }}</span>
                            </td>
                            <td>{{ $mhs->angkatan }}</td>
                            <td>
                                <span class="badge {{ $mhs->ipk >= 3.5 ? 'bg-success' : 'bg-primary' }}">
                                    {{ number_format($mhs->ipk, 2) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $mhs->status === 'Aktif' ? 'bg-success' : ($mhs->status === 'Cuti' ? 'bg-warning text-dark' : 'bg-info') }}">
                                    {{ $mhs->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- Tombol Lihat Detail (Bisa diakses Admin & Staf) --}}
                                    <a href="{{ route('dashboard.mahasiswa.show', $mhs) }}" class="btn btn-outline-info" title="Lihat Profil Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Tombol Edit (Bisa diakses Admin & Staf) --}}
                                    @can('edit-mahasiswa')
                                        <a href="{{ route('dashboard.mahasiswa.edit', $mhs) }}" class="btn btn-outline-warning" title="Edit Data Mahasiswa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    {{-- Tombol Hapus Data: HAK EKSKLUSIF ADMIN MURNI --}}
                                    {{-- Hanya dirender visual di Blade jika pengguna memegang peran Admin / izin delete-mahasiswa --}}
                                    @can('delete-mahasiswa')
                                        <button type="button" class="btn btn-outline-danger" title="Hapus Data (Khusus Admin)"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $mhs->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    @else
                                        {{-- Visual indicator untuk Staf bahwa tombol Hapus dikunci hak eksklusif --}}
                                        <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Hak Akses Hapus hanya untuk Admin">
                                            <button class="btn btn-outline-secondary disabled" style="pointer-events: none;" disabled>
                                                <i class="bi bi-lock-fill"></i>
                                            </button>
                                        </span>
                                    @endcan
                                </div>

                                {{-- Modal Konfirmasi Hapus (Hanya dirender untuk Admin) --}}
                                @can('delete-mahasiswa')
                                    <div class="modal fade" id="deleteModal{{ $mhs->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $mhs->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $mhs->id }}">
                                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Konfirmasi Hapus Data
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p>Apakah Anda yakin ingin menghapus data mahasiswa berikut secara permanen?</p>
                                                    <ul class="list-unstyled p-3 rounded border">
                                                        <li><strong>NRP:</strong> {{ $mhs->nrp }}</li>
                                                        <li><strong>Nama:</strong> {{ $mhs->nama }}</li>
                                                        <li><strong>Jurusan:</strong> {{ $mhs->jurusan }}</li>
                                                    </ul>
                                                    <p class="text-danger small mb-0"><i class="bi bi-info-circle"></i> Tindakan ini tidak dapat dibatalkan.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form method="POST" action="{{ route('dashboard.mahasiswa.destroy', $mhs) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash-fill me-1"></i> Ya, Hapus Sekarang
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada data mahasiswa yang cocok dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pengunci Link Pagination (withQueryString()) --}}
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
                Menampilkan {{ $mahasiswas->firstItem() ?? 0 }} - {{ $mahasiswas->lastItem() ?? 0 }} dari {{ $mahasiswas->total() }} total mahasiswa
            </div>
            <div>
                {{ $mahasiswas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
