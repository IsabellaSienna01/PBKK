<?php

use Illuminate\Support\Facades\Route;

$ownerNrp = '5025241199';

$showMahasiswa = function (string $nrp) use ($ownerNrp) {
    if ($nrp !== $ownerNrp) {
        return response()->view('fallback', [], 404);
    }

    return view('mahasiswa', [
        'nrp' => $nrp,
    ]);
};

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/mahasiswa/{nrp}', $showMahasiswa)
    ->where('nrp', '[0-9]{10}')
    ->name('mahasiswa.show');

Route::get('/agent/{tema?}', function (string $tema = 'General Assistant Agent') {
    return view('agent', [
        'tema' => $tema,
    ]);
})
    ->where('tema', 'ai-optimizer')
    ->name('agent.show');

Route::get('/hitung-ipk/{ip1}/{ip2}', function (string $ip1, string $ip2) {
    if (! is_numeric($ip1) || ! is_numeric($ip2)) {
        return response()->view('ipk', [
            'errorMessage' => 'Nilai IPK harus berupa angka antara 0.00 sampai 4.00.',
            'ip1' => $ip1,
            'ip2' => $ip2,
        ], 422);
    }

    $semesterOneGpa = (float) $ip1;
    $semesterTwoGpa = (float) $ip2;

    if ($semesterOneGpa < 0 || $semesterOneGpa > 4 || $semesterTwoGpa < 0 || $semesterTwoGpa > 4) {
        return response()->view('ipk', [
            'errorMessage' => 'Nilai IPK harus berada pada rentang 0.00 sampai 4.00.',
            'ip1' => $ip1,
            'ip2' => $ip2,
        ], 422);
    }

    $totalIp = $semesterOneGpa + $semesterTwoGpa;
    $ipk = $totalIp / 2;

    return view('ipk', [
        'ip1' => number_format($semesterOneGpa, 2),
        'ip2' => number_format($semesterTwoGpa, 2),
        'totalIp' => number_format($totalIp, 2),
        'ipk' => number_format($ipk, 2),
    ]);
})->name('ipk.calculate');

Route::prefix('dashboard')->name('dashboard.')->group(function () use ($showMahasiswa) {
    Route::get('/mahasiswa/{nrp}', $showMahasiswa)
        ->where('nrp', '[0-9]{10}')
        ->name('mahasiswa.show');
});

Route::fallback(function () {
    return response()->view('fallback', [], 404);
})->name('fallback');
