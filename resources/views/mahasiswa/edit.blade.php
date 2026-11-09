@extends('adminlte::page')

@section('title', 'Edit Student Record')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">Edit Student Record</h1>
            <p class="text-muted m-0 small">Update academic information details for student</p>
        </div>
        <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header">
                    <h3 class="card-title fw-bold mb-0">Student Update Form</h3>
                </div>
                <form method="POST" action="{{ route('dashboard.mahasiswa.update', $mahasiswa) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- NRP --}}
                            <div class="col-md-6">
                                <label for="nrp" class="form-label fw-semibold">Student ID (NRP) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp"
                                    value="{{ old('nrp', $mahasiswa->nrp) }}" required>
                                @error('nrp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                    value="{{ old('nama', $mahasiswa->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email Kampus --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Campus Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                    value="{{ old('email', $mahasiswa->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div class="col-md-6">
                                <label for="jurusan" class="form-label fw-semibold">Study Program / Department <span class="text-danger">*</span></label>
                                <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" required>
                                    @foreach($daftarJurusan as $j)
                                        <option value="{{ $j }}" {{ old('jurusan', $mahasiswa->jurusan) === $j ? 'selected' : '' }}>
                                            {{ $j }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Angkatan --}}
                            <div class="col-md-4">
                                <label for="angkatan" class="form-label fw-semibold">Cohort / Admission Year <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan"
                                    value="{{ old('angkatan', $mahasiswa->angkatan) }}" min="2000" max="2030" required>
                                @error('angkatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- IPK --}}
                            <div class="col-md-4">
                                <label for="ipk" class="form-label fw-semibold">GPA <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('ipk') is-invalid @enderror" id="ipk" name="ipk"
                                    value="{{ old('ipk', number_format($mahasiswa->ipk, 2, '.', '')) }}" min="0.00" max="4.00" required>
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Academic Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="Aktif" {{ old('status', $mahasiswa->status) === 'Aktif' ? 'selected' : '' }}>Active</option>
                                    <option value="Cuti" {{ old('status', $mahasiswa->status) === 'Cuti' ? 'selected' : '' }}>On Leave</option>
                                    <option value="Lulus" {{ old('status', $mahasiswa->status) === 'Lulus' ? 'selected' : '' }}>Graduated</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-warning fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> Update Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h3 class="card-title fw-bold mb-0">Authorization Information</h3>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">
                        Editing this record is accessible by both <strong>Admin</strong> and <strong>Staff</strong> roles according to the <code>edit-mahasiswa</code> permission.
                    </p>
                    <p class="small text-muted mb-0">
                        Permanently deleting this student record requires pure <strong>Admin</strong> privileges.
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop
