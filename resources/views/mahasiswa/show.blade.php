@extends('adminlte::page')

@section('title', 'Detail Mahasiswa - ' . $mahasiswa->nama)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0 font-weight-bold">Profil Lengkap Mahasiswa</h1>
            <p class="text-muted m-0 small">Detail data akademik mahasiswa terdaftar</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.mahasiswa.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
            @can('edit-mahasiswa')
                <a href="{{ route('dashboard.mahasiswa.edit', $mahasiswa) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square me-1"></i> Edit Data
                </a>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-outline card-primary shadow-sm text-center">
                <div class="card-body">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->nama) }}&size=128&background=0D8ABC&color=fff"
                        alt="Avatar" class="rounded-circle shadow-sm mb-3" width="100" height="100">
                    <h4 class="fw-bold mb-1">{{ $mahasiswa->nama }}</h4>
                    <p class="text-muted font-monospace mb-2">{{ $mahasiswa->nrp }}</p>
                    <span class="badge {{ $mahasiswa->status === 'Aktif' ? 'bg-success' : ($mahasiswa->status === 'Cuti' ? 'bg-warning text-dark' : 'bg-info') }} px-3 py-1.5 fs-6">
                        {{ $mahasiswa->status }}
                    </span>
                    <hr>
                    <div class="text-start small text-muted">
                        <div class="mb-2">
                            <i class="bi bi-envelope me-2 text-primary"></i> {{ $mahasiswa->email }}
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-mortarboard me-2 text-primary"></i> {{ $mahasiswa->jurusan }}
                        </div>
                        <div>
                            <i class="bi bi-calendar3 me-2 text-primary"></i> Angkatan {{ $mahasiswa->angkatan }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card card-outline card-secondary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title fw-bold mb-0">Rincian Akademik</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th class="w-25">Nomor Registrasi Pokok</th>
                                <td class="font-monospace fw-bold text-primary">{{ $mahasiswa->nrp }}</td>
                            </tr>
                            <tr>
                                <th>Nama Mahasiswa</th>
                                <td class="fw-semibold">{{ $mahasiswa->nama }}</td>
                            </tr>
                            <tr>
                                <th>Email Institusi</th>
                                <td>{{ $mahasiswa->email }}</td>
                            </tr>
                            <tr>
                                <th>Program Studi</th>
                                <td>{{ $mahasiswa->jurusan }}</td>
                            </tr>
                            <tr>
                                <th>Tahun Masuk / Angkatan</th>
                                <td>{{ $mahasiswa->angkatan }}</td>
                            </tr>
                            <tr>
                                <th>Indeks Prestasi Kumulatif</th>
                                <td>
                                    <span class="badge {{ $mahasiswa->ipk >= 3.5 ? 'bg-success' : 'bg-primary' }} fs-6">
                                        {{ number_format($mahasiswa->ipk, 2) }} / 4.00
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status Akademik</th>
                                <td>
                                    <span class="badge {{ $mahasiswa->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $mahasiswa->status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Terdaftar Pada</th>
                                <td class="text-muted small">{{ $mahasiswa->created_at?->format('d F Y, H:i') ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <a href="{{ route('mahasiswa.show', $mahasiswa->nrp) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-box-arrow-up-right me-1"></i> Buka Halaman Profil Publik
                    </a>

                    {{-- Tombol Hapus: Hak Eksklusif Admin --}}
                    @can('delete-mahasiswa')
                        <form method="POST" action="{{ route('dashboard.mahasiswa.destroy', $mahasiswa) }}" class="d-inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash-fill me-1"></i> Hapus Mahasiswa Ini (Admin)
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@stop
