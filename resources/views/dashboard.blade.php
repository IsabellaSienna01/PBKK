@extends('adminlte::page')

@section('title', 'Backoffice Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold">Backoffice Dashboard</h1>
            <p class="text-muted m-0 small">Academic Information System &amp; RBAC Portal - Institut Teknologi Sepuluh Nopember</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            @role('Admin')
                <span class="badge bg-danger px-3 py-2 fs-6 shadow-sm">
                    <i class="bi bi-shield-check me-1"></i> Role: Admin (Full Access)
                </span>
            @else
                <span class="badge bg-info px-3 py-2 fs-6 shadow-sm text-white">
                    <i class="bi bi-person-check me-1"></i> Role: Staff (Limited Access)
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
                <h5 class="fw-bold mb-1">User Authorization Status (Spatie RBAC)</h5>
                <p class="mb-1">
                    Welcome, <strong>{{ auth()->user()->name }}</strong> (<code>{{ auth()->user()->email }}</code>).
                    You are currently logged in with roles:
                    @foreach(auth()->user()->roles as $role)
                        <span class="badge bg-primary">{{ $role->name }}</span>
                    @endforeach
                </p>
                <div class="small text-muted">
                    @role('Admin')
                        <span class="text-success fw-bold"><i class="bi bi-unlock-fill"></i> Privileges:</span> You have full permissions to manage records, <strong>delete data (Exclusive Privilege)</strong>, and manage system users.
                    @else
                        <span class="text-warning fw-bold"><i class="bi bi-lock-fill"></i> Access Restrictions:</span> You can view, create, and update academic data; however, the <strong>'Delete Data' action is visually hidden in Blade and strictly protected at the Controller level</strong>.
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
                text="Total Students"
                icon="bi bi-people-fill"
                theme="primary"
                url="{{ route('dashboard.mahasiswa.index') }}"
                url-text="Manage Students" />
        </div>

        {{-- Widget 2: Total Mata Kuliah --}}
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box
                title="{{ $totalMataKuliah }}"
                text="Curriculum Courses"
                icon="bi bi-journal-bookmark-fill"
                theme="success"
                url="{{ route('dashboard.matakuliah.index') }}"
                url-text="Manage Curriculum" />
        </div>

        {{-- Widget 3: Total Ide Agentic AI --}}
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box
                title="{{ $totalIdeAgent }}"
                text="Agentic AI Proposals"
                icon="bi bi-cpu-fill"
                theme="info"
                url="{{ route('dashboard.ide-agent.index') }}"
                url-text="Review Proposals" />
        </div>

        {{-- Widget 4: Total User Terdaftar --}}
        <div class="col-lg-3 col-6">
            <x-adminlte-small-box
                title="{{ $totalUsers }}"
                text="Registered Users"
                icon="bi bi-person-badge-fill"
                theme="warning"
                url="{{ auth()->user()->can('manage-users') ? route('dashboard.users.index') : '#' }}"
                url-text="{{ auth()->user()->can('manage-users') ? 'Manage Permissions' : 'Admin Only' }}" />
        </div>
    </div>

    {{-- Secondary Metric Row: Distribusi Mahasiswa --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 col-12 mb-2">
            <div class="card card-outline card-success shadow-sm mb-0">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted text-uppercase fw-bold small">Active Students</span>
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
                        <span class="text-muted text-uppercase fw-bold small">On Leave Students</span>
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
                        <span class="text-muted text-uppercase fw-bold small">Graduated / Alumni</span>
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
                        <span class="text-muted text-uppercase fw-bold small">Average GPA</span>
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
                        <i class="bi bi-clock-history me-1"></i> Recent Students
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-xs btn-primary">
                            View All Students
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th>NRP</th>
                                <th>Student Name</th>
                                <th>Department</th>
                                <th>GPA</th>
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
                                            {{ $mhs->status === 'Aktif' ? 'Active' : ($mhs->status === 'Cuti' ? 'On Leave' : 'Graduated') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">No student records found.</td>
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
                        <i class="bi bi-robot me-1"></i> Agentic AI Proposals
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('dashboard.ide-agent.index') }}" class="btn btn-xs btn-info text-white">
                            View All Ideas
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Idea Title</th>
                                <th>Author</th>
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
                                            {{ $ide->status === 'Disetujui' ? 'Approved' : ($ide->status === 'Ditolak' ? 'Rejected' : 'Under Review') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">No proposals submitted yet.</td>
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
