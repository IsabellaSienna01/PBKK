@extends('adminlte::page')

@section('title', 'Tambah Mahasiswa Baru')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">Tambah Mahasiswa Baru</h1>
            <p class="text-muted m-0 small">Formulir pendaftaran data mahasiswa baru ke portal akademik</p>
        </div>
        <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title fw-bold mb-0">Informasi Mahasiswa</h3>
                </div>
                <form method="POST" action="{{ route('dashboard.mahasiswa.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            {{-- NRP --}}
                            <div class="col-md-6">
                                <label for="nrp" class="form-label fw-semibold">NRP (Nomor Registrasi Pokok) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nrp') is-invalid @enderror" id="nrp" name="nrp"
                                    value="{{ old('nrp') }}" placeholder="Contoh: 5025241001" required>
                                @error('nrp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Lengkap --}}
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                                    value="{{ old('nama') }}" placeholder="Contoh: Budi Santoso" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email Kampus --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Kampus <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                    value="{{ old('email') }}" placeholder="budi.santoso@student.its.ac.id" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jurusan --}}
                            <div class="col-md-6">
                                <label for="jurusan" class="form-label fw-semibold">Program Studi / Jurusan <span class="text-danger">*</span></label>
                                <select class="form-select @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" required>
                                    <option value="">-- Pilih Program Studi --</option>
                                    @foreach($daftarJurusan as $j)
                                        <option value="{{ $j }}" {{ old('jurusan') === $j ? 'selected' : '' }}>
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
                                <label for="angkatan" class="form-label fw-semibold">Tahun Angkatan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan"
                                    value="{{ old('angkatan', 2024) }}" min="2000" max="2030" required>
                                @error('angkatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- IPK --}}
                            <div class="col-md-4">
                                <label for="ipk" class="form-label fw-semibold">Indeks Prestasi Kumulatif (IPK) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('ipk') is-invalid @enderror" id="ipk" name="ipk"
                                    value="{{ old('ipk', '3.50') }}" min="0.00" max="4.00" required>
                                @error('ipk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Akademik --}}
                            <div class="col-md-4">
                                <label for="status" class="form-label fw-semibold">Status Akademik <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="Aktif" {{ old('status', 'Aktif') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Cuti" {{ old('status') === 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                    <option value="Lulus" {{ old('status') === 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Simpan Data Mahasiswa
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-outline card-info shadow-sm">
                <div class="card-header">
                    <h3 class="card-title fw-bold mb-0">Petunjuk Pengisian</h3>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        Pastikan data NRP dan Email unik dan belum pernah didaftarkan sebelumnya.
                    </p>
                    <ul class="small text-muted ps-3">
                        <li><strong>NRP</strong>: Nomor Registrasi Pokok mahasiswa.</li>
                        <li><strong>IPK</strong>: Rentang nilai 0.00 hingga 4.00.</li>
                        <li><strong>Status</strong>: Status keaktifan perkuliahan saat ini.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
