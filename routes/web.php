<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/beranda', [PageController::class, 'home'])->name('home.alias');
Route::get('/profil-mahasiswa', [PageController::class, 'profile'])->name('profile');
Route::get('/ide-agent', [PageController::class, 'agentIdea'])->name('agent.idea');
Route::post('/ide-agent', [PageController::class, 'submitIdea'])->name('agent.idea.submit');

Route::get('/mahasiswa/{nrp}', [PageController::class, 'legacyProfile'])
    ->where('nrp', '[0-9]{10}')
    ->name('mahasiswa.show');

Route::get('/agent/{tema?}', [PageController::class, 'agentIdea'])
    ->where('tema', 'ai-optimizer')
    ->name('agent.show');

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/mahasiswa/{nrp}', [PageController::class, 'legacyProfile'])
        ->where('nrp', '[0-9]{10}')
        ->name('mahasiswa.show');
});

Route::fallback(function () {
    return response()->view('fallback', [], 404);
})->name('fallback');
