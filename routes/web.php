<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IdeAgentDashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Portal Akademik Mahasiswa)
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Authenticated Routes (AdminLTE Backoffice & RBAC)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // 1. Dashboard Overview with Aggregates
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Data Mahasiswa Management
    Route::prefix('dashboard/mahasiswa')->name('dashboard.mahasiswa.')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('index');
        Route::get('/create', [MahasiswaController::class, 'create'])->name('create');
        Route::post('/', [MahasiswaController::class, 'store'])->name('store');
        Route::get('/{mahasiswa}', [MahasiswaController::class, 'show'])->name('show');
        Route::get('/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('edit');
        Route::put('/{mahasiswa}', [MahasiswaController::class, 'update'])->name('update');
        Route::delete('/{mahasiswa}', [MahasiswaController::class, 'destroy'])
            ->middleware('permission:delete-mahasiswa')
            ->name('destroy');
    });

    // 3. Data Mata Kuliah Management
    Route::prefix('dashboard/matakuliah')->name('dashboard.matakuliah.')->group(function () {
        Route::get('/', [MataKuliahController::class, 'index'])->name('index');
        Route::get('/create', [MataKuliahController::class, 'create'])->name('create');
        Route::post('/', [MataKuliahController::class, 'store'])->name('store');
        Route::get('/{matakuliah}/edit', [MataKuliahController::class, 'edit'])->name('edit');
        Route::put('/{matakuliah}', [MataKuliahController::class, 'update'])->name('update');
        Route::delete('/{matakuliah}', [MataKuliahController::class, 'destroy'])
            ->middleware('permission:delete-matakuliah')
            ->name('destroy');
    });

    // 4. Ide Agentic AI Management
    Route::prefix('dashboard/ide-agent')->name('dashboard.ide-agent.')->group(function () {
        Route::get('/', [IdeAgentDashboardController::class, 'index'])->name('index');
        Route::patch('/{ide}/status', [IdeAgentDashboardController::class, 'updateStatus'])->name('status');
        Route::delete('/{ide}', [IdeAgentDashboardController::class, 'destroy'])
            ->middleware('permission:delete-ide-agent')
            ->name('destroy');
    });

    // 5. User & RBAC Management (Admin Only)
    Route::prefix('dashboard/users')->name('dashboard.users.')->middleware('permission:manage-users')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::patch('/{user}/role', [UserManagementController::class, 'updateRole'])->name('role');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication Routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Fallback 404 Route
Route::fallback(function () {
    return response()->view('fallback', [], 404);
})->name('fallback');
