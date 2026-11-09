<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-matakuliah')->only(['index', 'show']);
        $this->middleware('permission:create-matakuliah')->only(['create', 'store']);
        $this->middleware('permission:edit-matakuliah')->only(['edit', 'update']);
        $this->middleware('permission:delete-matakuliah')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');
        $semester = $request->query('semester');

        $mataKuliahs = MataKuliah::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_mk', 'like', "%{$search}%")
                        ->orWhere('kode', 'like', "%{$search}%")
                        ->orWhere('dosen_pengampu', 'like', "%{$search}%");
                });
            })
            ->when($semester, function ($query, $semester) {
                $query->where('semester', $semester);
            })
            ->orderBy('semester')
            ->orderBy('kode')
            ->paginate(8)
            ->withQueryString();

        return view('matakuliah.index', compact('mataKuliahs', 'search', 'semester'));
    }

    public function create(): View
    {
        return view('matakuliah.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:mata_kuliahs,kode'],
            'nama_mk' => ['required', 'string', 'max:150'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:8'],
            'dosen_pengampu' => ['required', 'string', 'max:150'],
        ]);

        MataKuliah::create($validated);

        return redirect()->route('dashboard.matakuliah.index')
            ->with('success', 'New course curriculum created successfully.');
    }

    public function edit(MataKuliah $matakuliah): View
    {
        return view('matakuliah.edit', compact('matakuliah'));
    }

    public function update(Request $request, MataKuliah $matakuliah): RedirectResponse
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:20', 'unique:mata_kuliahs,kode,'.$matakuliah->id],
            'nama_mk' => ['required', 'string', 'max:150'],
            'sks' => ['required', 'integer', 'min:1', 'max:6'],
            'semester' => ['required', 'integer', 'min:1', 'max:8'],
            'dosen_pengampu' => ['required', 'string', 'max:150'],
        ]);

        $matakuliah->update($validated);

        return redirect()->route('dashboard.matakuliah.index')
            ->with('success', 'Course curriculum updated successfully.');
    }

    public function destroy(MataKuliah $matakuliah): RedirectResponse
    {
        // Hak Eksklusif Admin - Server-side authorization check
        /** @var User|null $user */
        $user = Auth::user();

        abort_if(
            ! $user || ! $user->can('delete-matakuliah'),
            403,
            'Access Denied: Only Admin can delete course curriculum.'
        );

        $nama = $matakuliah->nama_mk;
        $matakuliah->delete();

        return redirect()->route('dashboard.matakuliah.index')
            ->with('success', "Course ({$nama}) successfully deleted by Admin.");
    }
}
