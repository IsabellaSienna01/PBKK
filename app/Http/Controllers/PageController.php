<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
        return view('mahasiswa', ['nrp' => self::OWNER_NRP]);
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

        return redirect()->route('agent.idea')
            ->with('idea_success', 'Thank you, '.$validated['nama'].'! We appreciate your idea.');
    }
}
