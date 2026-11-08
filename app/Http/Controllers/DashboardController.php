<?php

namespace App\Http\Controllers;

use App\Models\IdeAgent;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view-dashboard']);
    }

    public function index(Request $request): View
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalMataKuliah = MataKuliah::count();
        $totalIdeAgent = IdeAgent::count();
        $totalUsers = User::count();

        $mahasiswaAktif = Mahasiswa::where('status', 'Aktif')->count();
        $mahasiswaCuti = Mahasiswa::where('status', 'Cuti')->count();
        $mahasiswaLulus = Mahasiswa::where('status', 'Lulus')->count();
        $avgIpk = round((float) Mahasiswa::avg('ipk'), 2);

        $latestMahasiswa = Mahasiswa::latest()->take(5)->get();
        $latestIde = IdeAgent::latest()->take(5)->get();

        return view('dashboard', compact(
            'totalMahasiswa',
            'totalMataKuliah',
            'totalIdeAgent',
            'totalUsers',
            'mahasiswaAktif',
            'mahasiswaCuti',
            'mahasiswaLulus',
            'avgIpk',
            'latestMahasiswa',
            'latestIde'
        ));
    }
}
