@extends('adminlte::page')

@section('title', 'Agentic AI Idea Proposals')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="m-0 font-weight-bold">Agentic AI Idea Proposals</h1>
            <p class="text-muted m-0 small">List of AI innovation proposals and ideas submitted by students</p>
        </div>
        <a href="{{ route('agent.idea') }}" target="_blank" class="btn btn-outline-primary shadow-sm">
            <i class="bi bi-box-arrow-up-right me-1"></i> Open Public Idea Form
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
        <div class="card-header">
            <h3 class="card-title fw-bold mb-0">
                <i class="bi bi-search me-1"></i> Filter Agentic AI Ideas (<code>when()</code> Query)
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('dashboard.ide-agent.index') }}" class="row g-3">
                <div class="col-md-7">
                    <label for="search" class="form-label small fw-semibold text-secondary">Search Title, Submitter Name, or Description</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search"
                            value="{{ request('search') }}" placeholder="Type idea keyword...">
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label small fw-semibold text-secondary">Proposal Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="Menunggu Review" {{ request('status') === 'Menunggu Review' ? 'selected' : '' }}>Under Review</option>
                        <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Approved</option>
                        <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Rejected</option>
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
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h3 class="card-title fw-bold mb-0">
                    <i class="bi bi-cpu-fill me-1"></i> Agentic AI Innovation Proposals
                </h3>
                <span class="badge bg-secondary ms-2">{{ $ideas->total() }} Ideas Registered</span>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Idea Proposal Title</th>
                        <th>Submitter</th>
                        <th style="width: 40%;">Description Summary</th>
                        <th>Status</th>
                        <th style="width: 170px;" class="text-center">Action / Verification</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ideas as $index => $ide)
                        <tr>
                            <td>{{ $ideas->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold">{{ $ide->judul_ide }}</div>
                                <div class="text-muted small"><i class="bi bi-clock"></i> {{ $ide->created_at?->diffForHumans() }}</div>
                            </td>
                            <td><span class="badge bg-secondary">{{ $ide->nama }}</span></td>
                            <td><p class="small text-secondary mb-0">{{ Str::limit($ide->deskripsi, 140) }}</p></td>
                            <td>
                                <span class="badge {{ $ide->status === 'Disetujui' ? 'bg-success' : ($ide->status === 'Ditolak' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ $ide->status === 'Disetujui' ? 'Approved' : ($ide->status === 'Ditolak' ? 'Rejected' : 'Under Review') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    {{-- Form update status --}}
                                    <div class="dropdown">
                                        <button class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Update Status
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li>
                                                <form method="POST" action="{{ route('dashboard.ide-agent.status', $ide) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="Disetujui">
                                                    <button type="submit" class="dropdown-item text-success"><i class="bi bi-check-circle me-1"></i> Approve</button>
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
                                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-x-circle me-1"></i> Reject</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- HAK EKSKLUSIF ADMIN --}}
                                    @can('delete-ide-agent')
                                        <form method="POST" action="{{ route('dashboard.ide-agent.destroy', $ide) }}" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this idea proposal?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-outline-danger" title="Delete Idea (Admin Only)">
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
                                No idea proposals found matching the filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-end">
            {{ $ideas->links('pagination::bootstrap-5') }}
        </div>
    </div>
@stop
