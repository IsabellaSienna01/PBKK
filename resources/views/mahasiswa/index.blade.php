@extends('adminlte::page')

@section('title', 'Student Records')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold">Student Records Management</h1>
            <p class="text-muted m-0 small">List of students registered in the academic portal</p>
        </div>
        <div>
            @can('create-mahasiswa')
                <a href="{{ route('dashboard.mahasiswa.create') }}" class="btn btn-primary shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New Student
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

    {{-- Filter Pencarian & Kueri when() (Challenge A+) --}}
    <div class="card card-outline card-primary shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title fw-bold mb-0">
                <i class="bi bi-search me-1"></i> Filter & Search Data (<code>when()</code> Query)
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.mahasiswa.index') }}" class="row g-3">
                {{-- Input Kata Kunci --}}
                <div class="col-md-5">
                    <label for="search" class="form-label small fw-semibold text-secondary">Search (Name, NRP, or Email)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Type keyword...">
                    </div>
                </div>

                {{-- Filter Jurusan --}}
                <div class="col-md-3">
                    <label for="jurusan" class="form-label small fw-semibold text-secondary">Study Program / Department</label>
                    <select class="form-select" id="jurusan" name="jurusan">
                        <option value="">All Study Programs</option>
                        @foreach($daftarJurusan as $j)
                            <option value="{{ $j }}" {{ request('jurusan') === $j ? 'selected' : '' }}>
                                {{ $j }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div class="col-md-2">
                    <label for="status" class="form-label small fw-semibold text-secondary">Academic Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Active</option>
                        <option value="Cuti" {{ request('status') === 'Cuti' ? 'selected' : '' }}>On Leave</option>
                        <option value="Lulus" {{ request('status') === 'Lulus' ? 'selected' : '' }}>Graduated</option>
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
                    <i class="bi bi-table me-1"></i> Student Records
                </h3>
                <span class="badge bg-secondary ms-2">{{ $mahasiswas->total() }} Total Records</span>
            </div>
            <div class="small text-muted">
                Showing page <strong>{{ $mahasiswas->currentPage() }}</strong> of <strong>{{ $mahasiswas->lastPage() }}</strong>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>NRP</th>
                        <th>Full Name</th>
                        <th>Campus Email</th>
                        <th>Department</th>
                        <th>Cohort</th>
                        <th>GPA</th>
                        <th>Status</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
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
                                    {{ $mhs->status === 'Aktif' ? 'Active' : ($mhs->status === 'Cuti' ? 'On Leave' : ($mhs->status === 'Lulus' ? 'Graduated' : $mhs->status)) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- Tombol Lihat Detail (Bisa diakses Admin & Staf) --}}
                                    <a href="{{ route('dashboard.mahasiswa.show', $mhs) }}" class="btn btn-outline-info" title="View Student Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Tombol Edit (Bisa diakses Admin & Staf) --}}
                                    @can('edit-mahasiswa')
                                        <a href="{{ route('dashboard.mahasiswa.edit', $mhs) }}" class="btn btn-outline-warning" title="Edit Student Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    {{-- Tombol Hapus Data: HAK EKSKLUSIF ADMIN MURNI --}}
                                    @can('delete-mahasiswa')
                                        <button type="button" class="btn btn-outline-danger" title="Delete Student (Admin Only)"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal{{ $mhs->id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    @else
                                        <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Delete permission restricted to Admin">
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
                                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> Confirm Permanent Deletion
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-start">
                                                    <p>Are you sure you want to permanently delete the following student data?</p>
                                                    <ul class="list-unstyled p-3 rounded border">
                                                        <li><strong>NRP:</strong> {{ $mhs->nrp }}</li>
                                                        <li><strong>Name:</strong> {{ $mhs->nama }}</li>
                                                        <li><strong>Department:</strong> {{ $mhs->jurusan }}</li>
                                                    </ul>
                                                    <p class="text-danger small mb-0"><i class="bi bi-info-circle"></i> This action cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form method="POST" action="{{ route('dashboard.mahasiswa.destroy', $mhs) }}" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="bi bi-trash-fill me-1"></i> Yes, Delete Now
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
                                No student records found matching the search filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pengunci Link Pagination (withQueryString()) --}}
        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
                Showing {{ $mahasiswas->firstItem() ?? 0 }} - {{ $mahasiswas->lastItem() ?? 0 }} of {{ $mahasiswas->total() }} total students
            </div>
            <div>
                {{ $mahasiswas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
