@extends('adminlte::page')

@section('title', 'Proposal Ide Agentic AI')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 text-dark font-weight-bold">Proposal Ide Agentic AI</h1>
            <p class="text-muted m-0 small">Daftar ide dan aspirasi pengembangan kecerdasan buatan dari mahasiswa</p>
        </div>
        <a href="{{ route('agent.idea') }}" target="_blank" class="btn btn-outline-primary shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Buka Form Publik Ide
        </a>
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
    <div class="card card-outline card-info shadow-sm mb-4">
        <div class="card-header bg-light">
            <h3 class="card-title fw-bold text-dark mb-0">
                <i class="bi bi-search me-1"></i> Filter Ide Agentic AI (Kueri <code>when()</code>)
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.ide-agent.index') }}" class="row g-3">
                <div class="col-md-7">
                    <label for="search" class="form-label small fw-semibold text-secondary">Cari Judul, Nama Pengusul, atau Deskripsi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Ketik kata kunci ide...">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label small fw-semibold text-secondary">Status Proposal</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Review" {{ request('status') === 'Menunggu Review' ? 'selected' : '' }}>Menunggu Review</option>
                        <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-info text-white w-100">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('dashboard.ide-agent.index') }}" class="btn btn-outline-secondary" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Ide Agent --}}
    <div class="card card-outline card-secondary shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="card-title fw-bold mb-0">
                    <i class="bi bi-cpu-fill me-1"></i> Usulan Inovasi Agentic AI
                </h3>
                <span class="badge bg-secondary ms-2">{{ $ideas->total() }} Ide Terdaftar</span>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Judul Usulan Ide</th>
                        <th>Pengusul</th>
                        <th style="width: 40%;">Ringkasan Deskripsi</th>
                        <th>Status</th>
                        <th style="width: 170px;" class="text-center">Aksi / Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ideas as $index => $ide)
                        <tr>
                            <td>{{ $ideas->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $ide->judul_ide }}</div>
                                <div class="text-muted small"><i class="bi bi-clock"></i> {{ $ide->created_at?->diffForHumans() }}</div>
                            </td>
                            <td><span class="badge bg-light text-dark border">{{ $ide->nama }}</span></td>
                            <td><p class="small text-secondary mb-0">{{ Str::limit($ide->deskripsi, 140) }}</p></td>
                            <td>
                                <span class="badge {{ $ide->status === 'Disetujui' ? 'bg-success' : ($ide->status === 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $ide->status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    {{-- Form update status --}}
                                    <div class="dropdown">
                                        <button class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Ubah Status
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <form method="POST" action="{{ route('dashboard.ide-agent.status', $ide) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Disetujui">
                                                    <button type="submit" class="dropdown-item text-success"><i class="bi bi-check-circle me-1"></i> Setujui</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('dashboard.ide-agent.status', $ide) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Menunggu Review">
                                                    <button type="submit" class="dropdown-item text-warning"><i class="bi bi-hourglass me-1"></i> Review</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form method="POST" action="{{ route('dashboard.ide-agent.status', $ide) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Ditolak">
                                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-x-circle me-1"></i> Tolak</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- HAK EKSKLUSIF ADMIN --}}
                                    @can('delete-ide-agent')
                                        <form method="POST" action="{{ route('dashboard.ide-agent.destroy', $ide) }}" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus usulan ide ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus Ide (Khusus Admin)">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                Tidak ada proposal ide yang sesuai dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
                Menampilkan {{ $ideas->firstItem() ?? 0 }} - {{ $ideas->lastItem() ?? 0 }} dari {{ $ideas->total() }} ide
            </div>
            <div>
                {{ $ideas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@stop
