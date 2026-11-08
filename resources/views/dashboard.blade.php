@extends('adminlte::page')

@section('title', 'Dashboard Backoffice')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold">Dashboard Backoffice</h1>
            <p class="text-muted m-0 small">Sistem Informasi Akademik & Portal RBAC - Institut Teknologi Sepuluh Nopember</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @role('Admin')
                <span class="badge bg-danger px-3 py-2 fs-6 shadow-sm">
                    <i class="bi bi-shield-check me-1"></i> Peran: Admin (Akses Penuh)
                </span>
            @else
                <span class="badge bg-info px-3 py-2 fs-6 shadow-sm text-white">
                    <i class="bi bi-person-check me-1"></i> Peran: Staf (Akses Terbatas)
                </span>
            @endrole
        </div>
    </div>
@stop

@section('content')
    {{-- Alert Flash Message --}}
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- RBAC Status Overview Callout --}}
    <div class="callout callout-info shadow-sm mb-4">
        <div class="d-flex align-items-start gap-3">
            <div class="fs-1 text-primary">
                <i class="bi bi-info-circle-fill"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-1">Status Otorisasi Pengguna (Spatie RBAC)</h5>
                <p class="mb-1">
                    Selamat datang, <strong>{{ auth()->user()->name }}</strong> (<code>{{ auth()->user()->email }}</code>).
                    Saat ini Anda login dengan hak akses:
                    @foreach(auth()->user()->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                </p>
                <div class="small text-muted">
                    @role('Admin')
                        <span class="text-success fw-bold"><i class="bi bi-unlock-fill"></i> Hak Istimewa:</span> Anda memiliki izin penuh untuk mengelola data, <strong>menghapus data (Hak Eksklusif)</strong>, dan mengelola pengguna sistem.
                    @else
                        <span class="text-warning fw-bold"><i class="bi bi-lock-fill"></i> Pembatasan Akses:</span> Anda dapat melihat, menambah, dan menyunting data akademik, namun <strong>menu 'Hapus Data' disembunyikan visual di Blade dan dilindungi secara ketat di Controller</strong>.
                    @endrole
                </div>
            </div>
        </div>
    </div>

    {{-- Widget Dashboard Agregat (Minimal 3 Widget Box Statistik Dinamis) --}}
    <div class="row">
        {{-- Widget 1: Total Mahasiswa --}}
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box
                title="{{ $totalMahasiswa }}"
                text="Total Mahasiswa"
                icon="bi bi-people-fill"
                theme="primary"
                url="{{ route('dashboard.mahasiswa.index') }}"
                url-text="Kelola Mahasiswa" />
        </div>

        {{-- Widget 2: Total Mata Kuliah --}}
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box
                title="{{ $totalMataKuliah }}"
                text="Mata Kuliah Kurikulum"
                icon="bi bi-journal-bookmark-fill"
                theme="success"
                url="{{ route('dashboard.matakuliah.index') }}"
                url-text="Kelola Kurikulum" />
        </div>

        {{-- Widget 3: Total Ide Agentic AI --}}
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box
                title="{{ $totalIdeAgent }}"
                text="Proposal Ide Agentic"
                icon="bi bi-cpu-fill"
                theme="info"
                url="{{ route('dashboard.ide-agent.index') }}"
                url-text="Review Proposal" />
        </div>

        {{-- Widget 4: Total User Terdaftar --}}
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box
                title="{{ $totalUsers }}"
                text="Pengguna Terdaftar"
                icon="bi bi-person-badge-fill"
                theme="warning"
                url="{{ auth()->user()->can('manage-users') ? route('dashboard.users.index') : '#' }}"
                url-text="{{ auth()->user()->can('manage-users') ? 'Kelola Hak Akses' : 'Khusus Admin' }}" />
        </div>
    </div>

    {{-- Secondary Metric Row: Distribusi Mahasiswa --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 col-12 mb-2">
            <div class="card card-outline card-success shadow-sm mb-0">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-bold small">Mahasiswa Aktif</span>
                        <h4 class="mb-0 fw-bold text-success">{{ $mahasiswaAktif }}</h4>
                    </div>
                    <i class="bi bi-check2-circle fs-1 text-success opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12 mb-2">
            <div class="card card-outline card-warning shadow-sm mb-0">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-bold small">Mahasiswa Cuti</span>
                        <h4 class="mb-0 fw-bold text-warning">{{ $mahasiswaCuti }}</h4>
                    </div>
                    <i class="bi bi-pause-circle fs-1 text-warning opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12 mb-2">
            <div class="card card-outline card-info shadow-sm mb-0">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-bold small">Alumni / Lulus</span>
                        <h4 class="mb-0 fw-bold text-info">{{ $mahasiswaLulus }}</h4>
                    </div>
                    <i class="bi bi-mortarboard-fill fs-1 text-info opacity-75"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12 mb-2">
            <div class="card card-outline card-primary shadow-sm mb-0">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-bold small">Rata-Rata IPK</span>
                        <h4 class="mb-0 fw-bold text-primary">{{ number_format($avgIpk, 2) }} / 4.00</h4>
                    </div>
                    <i class="bi bi-graph-up-arrow fs-1 text-primary opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Tables Preview --}}
    <div class="row">
        {{-- Tabel Mahasiswa Terbaru --}}
        <div class="col-lg-7">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">
                        <i class="bi bi-clock-history me-1"></i> Data Mahasiswa Terbaru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-xs btn-primary">
                            Lihat Semua Mahasiswa
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>NRP</th>
                                <th>Nama Mahasiswa</th>
                                <th>Jurusan</th>
                                <th>IPK</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestMahasiswa as $mhs)
                                <tr>
                                    <td><span class="font-monospace fw-bold">{{ $mhs->nrp }}</span></td>
                                    <td>{{ $mhs->nama }}</td>
                                    <td><span class="badge bg-secondary">{{ $mhs->jurusan }}</span></td>
                                    <td><strong>{{ number_format($mhs->ipk, 2) }}</strong></td>
                                    <td>
                                        <span class="badge {{ $mhs->status === 'Aktif' ? 'bg-success' : ($mhs->status === 'Cuti' ? 'bg-warning text-dark' : 'bg-info') }}">
                                            {{ $mhs->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">Belum ada data mahasiswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tabel Usulan Ide AI Terbaru --}}
        <div class="col-lg-5">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header border-0 d-flex justify-content-between align-items-center">
                    <h3 class="card-title fw-bold">
                        <i class="bi bi-robot me-1"></i> Usulan Ide Agentic AI
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('dashboard.ide-agent.index') }}" class="btn btn-xs btn-info text-white">
                            Lihat Semua Ide
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Judul Ide</th>
                                <th>Pengusul</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestIde as $ide)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-truncate" style="max-width: 180px;" title="{{ $ide->judul_ide }}">
                                            {{ $ide->judul_ide }}
                                        </div>
                                    </td>
                                    <td class="small">{{ $ide->nama }}</td>
                                    <td>
                                        <span class="badge {{ $ide->status === 'Disetujui' ? 'bg-success' : ($ide->status === 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                            {{ $ide->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">Belum ada usulan ide.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .small-box .icon {
            font-size: 4rem;
            position: absolute;
            right: 15px;
            top: 15px;
            opacity: 0.25;
            transition: all 0.3s linear;
        }
        .small-box:hover .icon {
            transform: scale(1.1);
            opacity: 0.4;
        }
    </style>
@stop
