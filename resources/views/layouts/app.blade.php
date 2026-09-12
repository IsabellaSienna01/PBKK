<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Academic Profile')</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
        <header class="border-b border-slate-200 bg-white">
            <nav class="mx-auto max-w-6xl px-6 py-4 lg:px-8" aria-label="Navigasi utama">
                <div class="flex items-center justify-between gap-6">
                <a href="{{ route('home') }}" class="shrink-0">
                    <span class="block text-sm font-semibold tracking-tight text-slate-900">Academic Profile</span>
                    <span class="block text-xs text-slate-500">Isabella Sienna Sulisthio</span>
                </a>

                <div class="hidden items-center gap-1 text-sm font-medium text-slate-600 md:flex md:gap-5">
                    <a href="{{ route('home') }}" class="whitespace-nowrap rounded-md px-2 py-1.5 transition hover:bg-slate-100 hover:text-blue-700">Home</a>
                    <a href="{{ route('mahasiswa.show', ['nrp' => '5025241199']) }}" class="whitespace-nowrap rounded-md px-2 py-1.5 transition hover:bg-slate-100 hover:text-blue-700">Profile</a>
                    <a href="{{ route('agent.show', ['tema' => 'ai-optimizer']) }}" class="whitespace-nowrap rounded-md px-2 py-1.5 transition hover:bg-slate-100 hover:text-blue-700">Agentic AI</a>
                    <a href="{{ route('ipk.calculate', ['ip1' => '3.75', 'ip2' => '3.80']) }}" class="whitespace-nowrap rounded-md px-2 py-1.5 transition hover:bg-slate-100 hover:text-blue-700">GPA Calculator</a>
                </div>

                <button
                    id="mobile-menu-button"
                    type="button"
                    class="inline-flex size-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 transition hover:border-blue-300 hover:bg-blue-50 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 md:hidden"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                >
                    <span class="sr-only"></span>
                    <svg data-menu-icon="open" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                    <svg data-menu-icon="close" class="hidden size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18" />
                    </svg>
                </button>
                </div>

                <div id="mobile-menu" class="hidden border-t border-slate-200 pt-3 md:hidden">
                    <div class="flex flex-col gap-1 text-sm font-medium text-slate-600">
                        <a href="{{ route('home') }}" class="rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-blue-700">Home</a>
                        <a href="{{ route('mahasiswa.show', ['nrp' => '5025241199']) }}" class="rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-blue-700">Profile</a>
                        <a href="{{ route('agent.show', ['tema' => 'ai-optimizer']) }}" class="rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-blue-700">Agentic AI</a>
                        <a href="{{ route('ipk.calculate', ['ip1' => '3.75', 'ip2' => '3.80']) }}" class="rounded-md px-3 py-2.5 transition hover:bg-slate-100 hover:text-blue-700">GPA Calculator</a>
                    </div>
                </div>
            </nav>
        </header>

        <main>
            @yield('content')
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto flex max-w-6xl flex-col gap-2 px-6 py-6 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between lg:px-8">
                <p class="font-medium text-slate-700">Academic Profile</p>
                <p>PBKK · Informatics ITS · 2026</p>
            </div>
        </footer>
    </body>
</html>
