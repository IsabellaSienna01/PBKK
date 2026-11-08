<x-guest-layout>
    <!-- Header Title -->
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Portal Akademik <span class="text-blue-600 dark:text-blue-400">Backoffice</span>
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Silakan login untuk mengakses panel administrasi dan RBAC.
        </p>
    </div>

    <!-- Quick Demo Accounts (Challenge Evaluasi Dosen / Asdos) -->
    <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50/70 p-4 shadow-sm dark:border-blue-900 dark:bg-slate-800/80">
        <div class="flex items-center gap-2 mb-2">
            <span class="inline-flex size-6 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white">⚡</span>
            <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-200">Auto-Login Test Accounts (Quick Demo)</h3>
        </div>
        <p class="text-xs text-blue-800/80 mb-3 dark:text-slate-300">
            Gunakan tombol berikut untuk login instan tanpa mengetik password saat evaluasi demo kelas:
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <!-- Demo Admin -->
            <form method="POST" action="{{ route('demo.login') }}">
                @csrf
                <input type="hidden" name="role" value="admin">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition shadow-sm">
                    <span>👑</span>
                    <div class="text-left leading-tight">
                        <div class="font-bold">Login Admin</div>
                        <div class="text-[10px] text-emerald-100">Akses Penuh (Full RBAC)</div>
                    </div>
                </button>
            </form>

            <!-- Demo Staf -->
            <form method="POST" action="{{ route('demo.login') }}">
                @csrf
                <input type="hidden" name="role" value="staf">
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-sm">
                    <span>👤</span>
                    <div class="text-left leading-tight">
                        <div class="font-bold">Login Staf</div>
                        <div class="text-[10px] text-indigo-100">Akses Terbatas (No Delete)</div>
                    </div>
                </button>
            </form>
        </div>

        <div class="mt-2 text-[11px] text-gray-500 dark:text-slate-400 text-center">
            Password semua akun uji coba: <code class="px-1.5 py-0.5 rounded bg-white dark:bg-slate-700 text-gray-800 dark:text-slate-200 border dark:border-slate-600 font-mono">password</code>
        </div>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@academic.its.ac.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Back to Home -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-slate-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-slate-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Ingat saya') }}</span>
            </label>

            <a href="{{ route('home') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline">
                ← Kembali ke Portal
            </a>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-2.5 text-sm font-semibold">
                {{ __('Masuk ke Dashboard') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
