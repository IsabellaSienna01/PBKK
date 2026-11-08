@extends('adminlte::page')

@section('title', 'Edit Mata Kuliah - ' . $matakuliah->nama_mk)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">Edit Mata Kuliah</h1>
            <p class="text-muted m-0 small">Perbarui data kurikulum mata kuliah</p>
        </div>
        <a href="{{ route('dashboard.matakuliah.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header">
                    <h3 class="card-title fw-bold mb-0">Perbarui Rincian Mata Kuliah</h3>
                </div>
                <form method="POST" action="{{ route('dashboard.matakuliah.update', $matakuliah) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="kode" class="form-label fw-semibold">Kode Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror" id="kode" name="kode"
                                    value="{{ old('kode', $matakuliah->kode) }}" required>
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-8">
                                <label for="nama_mk" class="form-label fw-semibold">Nama Mata Kuliah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_mk') is-invalid @enderror" id="nama_mk" name="nama_mk"
                                    value="{{ old('nama_mk', $matakuliah->nama_mk) }}" required>
                                @error('nama_mk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="sks" class="form-label fw-semibold">Bobot SKS <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('sks') is-invalid @enderror" id="sks" name="sks"
                                    value="{{ old('sks', $matakuliah->sks) }}" min="1" max="6" required>
                                @error('sks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="semester" class="form-label fw-semibold">Semester Paket <span class="text-danger">*</span></label>
                                <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                                    @for($s = 1; $s <= 8; $s++)
                                        <option value="{{ $s }}" {{ old('semester', $matakuliah->semester) == $s ? 'selected' : '' }}>
                                            Semester {{ $s }}
                                        </option>
                                    @endfor
                                </select>
                                @error('semester')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="dosen_pengampu" class="form-label fw-semibold">Dosen Pengampu Utama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('dosen_pengampu') is-invalid @enderror" id="dosen_pengampu" name="dosen_pengampu"
                                    value="{{ old('dosen_pengampu', $matakuliah->dosen_pengampu) }}" required>
                                @error('dosen_pengampu')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard.matakuliah.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-warning fw-bold">
                            <i class="bi bi-check2-circle me-1"></i> Perbarui Mata Kuliah
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
