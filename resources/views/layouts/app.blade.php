<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ request()->query('mode') === 'dark' ? 'dark' : '' }}" data-theme-query="{{ in_array(request()->query('mode'), ['dark', 'light'], true) ? request()->query('mode') : '' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Academic Profile')</title>

        <script>
            (() => {
                const root = document.documentElement;
                const queryMode = root.dataset.themeQuery;
                let mode = queryMode;

                try {
                    if (queryMode) {
                        localStorage.setItem('theme', queryMode);
                    } else {
                        mode = localStorage.getItem('theme');
                    }
                } catch (_) {
                    // The theme still works for this page when storage is unavailable.
                }

                root.classList.toggle('dark', mode === 'dark');
            })();
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <header class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
            <nav class="mx-auto max-w-6xl px-6 py-4 lg:px-8" aria-label="Navigasi utama">
                <div class="flex items-center justify-between gap-6">
                <a href="{{ route('home') }}" class="shrink-0">
                    <span class="block text-sm font-semibold tracking-tight text-slate-900 dark:text-white">Academic Profile</span>
                    <span class="block text-xs text-slate-500 dark:text-slate-400">Isabella Sienna Sulisthio</span>
                </a>

                <div class="hidden items-center gap-1 text-sm font-medium text-slate-600 dark:text-slate-200 md:flex md:gap-5">
                    <a href="{{ route('home') }}" class="whitespace-nowrap rounded-md px-2 py-1.5 transition hover:bg-slate-100 hover:text-blue-700 dark:hover:bg-slate-800 dark:hover:text-blue-300">Home</a>
                    <a href="{{ route('profile') }}" class="whitespace-nowrap rounded-md px-2 py-1.5 transition hover:bg-slate-100 hover:text-blue-700 dark:hover:bg-slate-800 dark:hover:text-blue-300">Profile</a>
                    <a href="{{ route('agent.idea') }}" class="whitespace-nowrap rounded-md px-2 py-1.5 transition hover:bg-slate-100 hover:text-blue-700 dark:hover:bg-slate-800 dark:hover:text-blue-300">Agentic AI</a>
                </div>

                <div class="flex items-center gap-2">
                <button
                    id="theme-toggle"
                    type="button"
                    role="switch"
                    aria-label="Mode gelap"
                    aria-checked="false"
                    class="relative inline-flex h-9 w-16 shrink-0 items-center rounded-full border border-slate-300 bg-slate-200 transition-colors duration-200 hover:border-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-blue-500 dark:bg-blue-600 dark:focus:ring-offset-slate-900"
                >
                    <span class="ml-1 flex size-7 items-center justify-center rounded-full bg-white text-amber-500 shadow-sm transition-transform duration-200 ease-out dark:translate-x-7 dark:bg-slate-900 dark:text-blue-300">
                        <i data-lucide="sun" class="size-4 dark:hidden" aria-hidden="true"></i>
                        <i data-lucide="moon" class="hidden size-4 dark:block" aria-hidden="true"></i>
                    </span>
                </button>

                <button
                    id="mobile-menu-button"
                    type="button"
                    class="inline-flex size-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800 md:hidden"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                >
                    <svg data-menu-icon="open" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg data-menu-icon="close" class="hidden size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                    </svg>
                </button>
                </div>
                </div>

                <div id="mobile-menu" class="hidden border-t border-slate-200 pt-3 dark:border-slate-800 md:hidden">
                    <div class="flex flex-col gap-1 text-sm font-medium text-slate-600 dark:text-slate-200">
                        <a href="{{ route('home') }}" class="rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-blue-700 dark:hover:bg-slate-800 dark:hover:text-blue-300">Home</a>
                        <a href="{{ route('profile') }}" class="rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-blue-700 dark:hover:bg-slate-800 dark:hover:text-blue-300">Profile</a>
                        <a href="{{ route('agent.idea') }}" class="rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-blue-700 dark:hover:bg-slate-800 dark:hover:text-blue-300">Agentic AI</a>
                    </div>
                </div>
            </nav>
        </header>

        <main id="main-content" class="grow">
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
            <div class="mx-auto flex max-w-6xl flex-col gap-2 px-6 py-6 text-sm text-slate-500 dark:text-slate-400 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                <p class="font-medium text-slate-700 dark:text-slate-200">Academic Profile</p>
                <p>PBKK · Informatics ITS · 2026</p>
            </div>
        </footer>
    </body>
</html>
