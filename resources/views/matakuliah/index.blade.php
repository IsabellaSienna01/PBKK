@extends('adminlte::page')

@section('title', 'Kurikulum Mata Kuliah')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 text-dark font-weight-bold">Kurikulum Mata Kuliah</h1>
            <p class="text-muted m-0 small">Daftar mata kuliah aktif pada program studi</p>
        </div>
        <div>
            @can('create-matakuliah')
                <a href="{{ route('dashboard.matakuliah.create') }}" class="btn btn-success shadow-sm">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Mata Kuliah Baru
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
        <div class="card-header bg-light">
            <h3 class="card-title fw-bold text-dark mb-0">
                <i class="bi bi-search me-1"></i> Filter Mata Kuliah (Kueri <code>when()</code>)
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.matakuliah.index') }}" class="row g-3">
                <div class="col-md-7">
                    <label for="search" class="form-label small fw-semibold text-secondary">Cari (Nama MK, Kode, atau Dosen Pengampu)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Ketik kata kunci pencarian...">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="semester" class="form-label small fw-semibold text-secondary">Semester</label>
                    <select class="form-select" id="semester" name="semester">
                        <option value="">Semua Semester</option>
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
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="card-title fw-bold mb-0">
                    <i class="bi bi-journal-bookmark-fill me-1"></i> Daftar Mata Kuliah
                </h3>
                <span class="badge bg-secondary ms-2">{{ $mataKuliahs->total() }} Total MK</span>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Kode MK</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                        <th>Semester</th>
                        <th>Dosen Pengampu</th>
                        <th style="width: 150px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataKuliahs as $index => $mk)
                        <tr>
                            <td>{{ $mataKuliahs->firstItem() + $index }}</td>
                            <td><span class="font-monospace fw-bold text-success">{{ $mk->kode }}</span></td>
                            <td><div class="fw-semibold">{{ $mk->nama_mk }}</div></td>
                            <td><span class="badge bg-primary">{{ $mk->sks }} SKS</span></td>
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
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus mata kuliah {{ $mk->nama_mk }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus (Khusus Admin)">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-outline-secondary disabled" title="Hapus hanya untuk Admin" disabled>
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
                                Tidak ada data mata kuliah yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
                Menampilkan {{ $mataKuliahs->firstItem() ?? 0 }} - {{ $mataKuliahs->lastItem() ?? 0 }} dari {{ $mataKuliahs->total() }} mata kuliah
            </div>
            <div>
                {{ $mataKuliahs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
