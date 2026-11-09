@extends('adminlte::page')

@section('title', 'Course Curriculum')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold">Course Curriculum</h1>
            <p class="text-muted m-0 small">List of active courses in the study program curriculum</p>
        </div>
        <div>
            @can('create-matakuliah')
                <a href="{{ route('dashboard.matakuliah.create') }}" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Add New Course
                </a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Filter Pencarian when() --}}
    <div class="card card-outline card-success shadow-sm mb-4">
        <div class="card-header">
            <h3 class="card-title fw-bold mb-0">
                <i class="bi bi-search me-1"></i> Filter Courses (<code>when()</code> Query)
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.matakuliah.index') }}" class="row g-3">
                <div class="col-md-7">
                    <label for="search" class="form-label small fw-semibold text-secondary">Search (Course Name, Code, or Lecturer)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Type course keyword...">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="semester" class="form-label small fw-semibold text-secondary">Semester</label>
                    <select class="form-select" id="semester" name="semester">
                        <option value="">All Semesters</option>
                        @for($s = 1; $s <= 8; $s++)
                            <option value="{{ $s }}" {{ request('semester') == $s ? 'selected' : '' }}>
                                Semester {{ $s }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'semester']))
                        <a href="{{ route('dashboard.matakuliah.index') }}" class="btn btn-outline-secondary" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Mata Kuliah --}}
    <div class="card card-outline card-secondary shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="card-title fw-bold mb-0">
                    <i class="bi bi-journal-bookmark-fill me-1"></i> Curriculum Courses List
                </h3>
                <span class="badge bg-secondary ms-2">{{ $mataKuliahs->total() }} Total Courses</span>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Semester</th>
                        <th>Lecturer</th>
                        <th style="width: 150px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataKuliahs as $index => $mk)
                        <tr>
                            <td>{{ $mataKuliahs->firstItem() + $index }}</td>
                            <td><span class="font-monospace fw-bold text-success">{{ $mk->kode }}</span></td>
                            <td><div class="fw-semibold">{{ $mk->nama_mk }}</div></td>
                            <td><span class="badge bg-primary">{{ $mk->sks }} Credits</span></td>
                            <td>Semester {{ $mk->semester }}</td>
                            <td><span class="small">{{ $mk->dosen_pengampu }}</span></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    @can('edit-matakuliah')
                                        <a href="{{ route('dashboard.matakuliah.edit', $mk) }}" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    @endcan

                                    {{-- HAK EKSKLUSIF ADMIN --}}
                                    @can('delete-matakuliah')
                                        <form method="POST" action="{{ route('dashboard.matakuliah.destroy', $mk) }}" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete course {{ $mk->nama_mk }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete (Admin Only)">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary disabled" title="Delete permission restricted to Admin" disabled>
                                            <i class="bi bi-lock-fill"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No course records match the search filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
                Showing {{ $mataKuliahs->firstItem() ?? 0 }} - {{ $mataKuliahs->lastItem() ?? 0 }} of {{ $mataKuliahs->total() }} courses
            </div>
            <div>
                {{ $mataKuliahs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
