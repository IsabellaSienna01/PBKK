<?php

namespace App\Http\Controllers;

use App\Models\IdeAgent;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    private const OWNER_NRP = '5025241199';

    public function home(Request $request): View
    {
        $user = $request->query('user');

        return view('home', [
            'user' => is_string($user) ? trim($user) : null,
        ]);
    }

    public function profile(): View
    {
        $mahasiswa = Mahasiswa::where('nrp', self::OWNER_NRP)->first();

        return view('mahasiswa', [
            'nrp' => self::OWNER_NRP,
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function legacyProfile(string $nrp): View
    {
        $mahasiswa = Mahasiswa::where('nrp', $nrp)->first();

        return view('mahasiswa', [
            'nrp' => $nrp,
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function agentIdea(): View
    {
        return view('agent');
    }

    public function submitIdea(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'judul_ide' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string', 'max:2000'],
        ]);

        IdeAgent::create([
            'nama' => $validated['nama'],
            'judul_ide' => $validated['judul_ide'],
            'deskripsi' => $validated['deskripsi'],
            'status' => 'Menunggu Review',
        ]);

        return redirect()->route('agent.idea')
            ->with('idea_success', 'Thank you, '.$validated['nama'].'! Your idea has been successfully submitted and stored.');
    }
}
