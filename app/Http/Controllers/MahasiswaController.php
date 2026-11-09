<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-mahasiswa')->only(['index', 'show']);
        $this->middleware('permission:create-mahasiswa')->only(['create', 'store']);
        $this->middleware('permission:edit-mahasiswa')->only(['edit', 'update']);
        $this->middleware('permission:delete-mahasiswa')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');
        $jurusan = $request->query('jurusan');
        $status = $request->query('status');

        $mahasiswas = Mahasiswa::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nrp', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($jurusan, function ($query, $jurusan) {
                $query->where('jurusan', $jurusan);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $daftarJurusan = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Sains Data',
            'Teknik Komputer',
            'Rekayasa Perangkat Lunak',
        ];

        return view('mahasiswa.index', compact('mahasiswas', 'daftarJurusan', 'search', 'jurusan', 'status'));
    }

    public function create(): View
    {
        $daftarJurusan = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Sains Data',
            'Teknik Komputer',
            'Rekayasa Perangkat Lunak',
        ];

        return view('mahasiswa.create', compact('daftarJurusan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nrp' => ['required', 'string', 'max:15', 'unique:mahasiswas,nrp'],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:mahasiswas,email'],
            'jurusan' => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2030'],
            'ipk' => ['required', 'numeric', 'min:0.00', 'max:4.00'],
            'status' => ['required', 'in:Aktif,Cuti,Lulus'],
        ]);

        Mahasiswa::create($validated);

        return redirect()->route('dashboard.mahasiswa.index')
            ->with('success', 'New student record created successfully.');
    }

    public function show(Mahasiswa $mahasiswa): View
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        $daftarJurusan = [
            'Teknik Informatika',
            'Sistem Informasi',
            'Sains Data',
            'Teknik Komputer',
            'Rekayasa Perangkat Lunak',
        ];

        return view('mahasiswa.edit', compact('mahasiswa', 'daftarJurusan'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $validated = $request->validate([
            'nrp' => ['required', 'string', 'max:15', 'unique:mahasiswas,nrp,'.$mahasiswa->id],
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:mahasiswas,email,'.$mahasiswa->id],
            'jurusan' => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:2030'],
            'ipk' => ['required', 'numeric', 'min:0.00', 'max:4.00'],
            'status' => ['required', 'in:Aktif,Cuti,Lulus'],
        ]);

        $mahasiswa->update($validated);

        return redirect()->route('dashboard.mahasiswa.index')
            ->with('success', 'Student record updated successfully.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        // Hak Eksklusif Admin - Server-side authorization check
        /** @var User|null $user */
        $user = Auth::user();

        abort_if(
            ! $user || ! $user->can('delete-mahasiswa'),
            403,
            'Access Denied: Only Admin with exclusive permissions can delete student records.'
        );

        $nama = $mahasiswa->nama;
        $mahasiswa->delete();

        return redirect()->route('dashboard.mahasiswa.index')
            ->with('success', "Student record ({$nama}) permanently deleted by Admin.");
    }
}
