<?php

namespace App\Http\Controllers;

use App\Models\IdeAgent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IdeAgentDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-ide-agent')->only(['index']);
        $this->middleware('permission:delete-ide-agent')->only(['destroy']);
    }

    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');

        $ideas = IdeAgent::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul_ide', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('ide_agent.index', compact('ideas', 'search', 'status'));
    }

    public function updateStatus(Request $request, IdeAgent $ide): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Menunggu Review,Disetujui,Ditolak'],
        ]);

        $ide->update($validated);

        return redirect()->route('dashboard.ide-agent.index')
            ->with('success', 'Status ide berhasil diubah menjadi: '.$validated['status']);
    }

    public function destroy(IdeAgent $ide): RedirectResponse
    {
        // Hak Eksklusif Admin
        abort_if(
            ! auth()->user()->can('delete-ide-agent'),
            403,
            'Akses Ditolak: Hanya Admin yang berhak menghapus proposal ide.'
        );

        $judul = $ide->judul_ide;
        $ide->delete();

        return redirect()->route('dashboard.ide-agent.index')
            ->with('success', "Ide Agent ({$judul}) berhasil dihapus oleh Admin.");
    }
}
